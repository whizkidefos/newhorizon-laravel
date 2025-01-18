<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentVerification;
use Illuminate\Http\Request;
use App\Events\DocumentVerified;

class DocumentReviewController extends Controller
{
    public function index()
    {
        $pendingDocuments = Document::with(['user', 'latestVerification'])
            ->whereDoesntHave('verifications', function($query) {
                $query->where('status', 'approved')
                    ->where('expires_at', '>', now());
            })
            ->paginate(15);

        return view('admin.documents.review.index', compact('pendingDocuments'));
    }

    public function verify(Request $request, Document $document)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string',
            'expires_at' => 'required_if:status,approved|nullable|date|after:today'
        ]);

        $verification = DocumentVerification::create([
            'document_id' => $document->id,
            'verified_by' => auth()->id(),
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'expires_at' => $validated['expires_at']
        ]);

        DocumentVerified::dispatch($document, $verification);

        return redirect()->back()->with('success', 'Document verification updated successfully');
    }
}