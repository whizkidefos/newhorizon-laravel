<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PDF;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->where('is_admin', false)
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('mobile_number', 'like', "%{$search}%");
                });
            })
            ->when($request->job_role, function($query, $role) {
                $query->where('job_role', $role);
            })
            ->when($request->verification_status, function($query, $status) {
                if ($status === 'verified') {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            });

        // Debug: Log the SQL query
        Log::info('Users Query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        $users = $query->latest()->paginate(10)->withQueryString();

        // Debug: Log the number of users found
        Log::info('Users Count:', [
            'count' => $users->count(),
            'total' => $users->total()
        ]);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load([
            'documents',
            'certifications',
            'references',
            'shifts' => function($query) {
                $query->latest()->take(5);
            },
            'profileDetail',
            'bankDetail',
            'workHistory',
            'trainingRecords'
        ]);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::delete($user->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'User updated successfully');
    }

    public function verifyDocuments(Request $request, User $user)
    {
        $validated = $request->validate([
            'document_ids' => 'required|array',
            'document_ids.*' => 'exists:documents,id',
            'verification_status' => 'required|in:approved,rejected',
            'verification_notes' => 'nullable|string'
        ]);

        Document::whereIn('id', $validated['document_ids'])
            ->update([
                'verification_status' => $validated['verification_status'],
                'verification_notes' => $validated['verification_notes'],
                'verified_at' => now(),
                'verified_by' => auth()->id()
            ]);

        return back()->with('success', 'Documents verified successfully');
    }

    public function destroy(User $user)
    {
        // Soft delete or handle user deletion based on your requirements
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function export(Request $request, User $user)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|string|in:personal,documents,address,bank,work,training',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from'
        ]);

        // Load necessary relationships based on selected sections
        $relations = ['documents', 'certifications'];
        if (in_array('address', $request->sections)) {
            $relations[] = 'profileDetail';
        }
        if (in_array('bank', $request->sections)) {
            $relations[] = 'bankDetail';
        }
        if (in_array('work', $request->sections)) {
            $relations[] = 'workHistory';
        }
        if (in_array('training', $request->sections)) {
            $relations[] = 'trainingRecords';
        }

        $user->load($relations);

        // Filter data by date range if provided
        if ($request->date_from || $request->date_to) {
            $dateFrom = $request->date_from ? \Carbon\Carbon::parse($request->date_from) : null;
            $dateTo = $request->date_to ? \Carbon\Carbon::parse($request->date_to) : now();

            if (in_array('work', $request->sections)) {
                $user->workHistory = $user->workHistory->filter(function($work) use ($dateFrom, $dateTo) {
                    return (!$dateFrom || $work->start_date >= $dateFrom) &&
                           (!$dateTo || $work->start_date <= $dateTo);
                });
            }

            if (in_array('training', $request->sections)) {
                $user->trainingRecords = $user->trainingRecords->filter(function($training) use ($dateFrom, $dateTo) {
                    return (!$dateFrom || $training->completion_date >= $dateFrom) &&
                           (!$dateTo || $training->completion_date <= $dateTo);
                });
            }
        }

        // Generate PDF
        $pdf = PDF::loadView('admin.users.pdf.profile', [
            'user' => $user,
            'sections' => $request->sections
        ]);

        // Create filename using user's name
        $filename = 'employee-profile-' . strtolower(str_replace(' ', '-', $user->full_name)) . '.pdf';

        return $pdf->download($filename);
    }
}