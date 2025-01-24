<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $availableCourses = Course::where('status', 'active')->paginate(12);
        $enrolledCourses = auth()->user()->courses()->paginate(12);
        return view('courses.index', compact('availableCourses', 'enrolledCourses'));
    }

    public function show(Course $course)
    {
        $enrollment = auth()->user()->courses()->where('course_id', $course->id)->first();
        return view('courses.show', compact('course', 'enrollment'));
    }

    public function enroll(Request $request, Course $course)
    {
        $request->validate([
            'payment_method' => 'required|in:paypal,credit_card,bank_transfer'
        ]);

        // Check if user is already enrolled
        if (auth()->user()->courses()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'You are already enrolled in this course.');
        }

        // Enroll user in course
        auth()->user()->courses()->attach($course->id, [
            'status' => 'enrolled',
            'payment_status' => 'pending',
            'progress' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Successfully enrolled in course.');
    }

    public function progress(Course $course)
    {
        $enrollment = auth()->user()->courses()->where('course_id', $course->id)->firstOrFail();
        $modules = $course->modules()->with(['lessons' => function($query) use ($enrollment) {
            $query->withCount(['completions' => function($query) use ($enrollment) {
                $query->where('user_id', auth()->id());
            }]);
        }])->get();

        return view('courses.progress', compact('course', 'enrollment', 'modules'));
    }

    public function updateProgress(Request $request, Course $course)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'completed' => 'required|boolean'
        ]);

        $enrollment = auth()->user()->courses()->where('course_id', $course->id)->firstOrFail();
        
        if ($request->completed) {
            auth()->user()->completedLessons()->attach($request->lesson_id, [
                'completed_at' => now()
            ]);
        } else {
            auth()->user()->completedLessons()->detach($request->lesson_id);
        }

        // Update overall course progress
        $totalLessons = $course->lessons()->count();
        $completedLessons = auth()->user()->completedLessons()
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->count();
        
        $progress = ($totalLessons > 0) ? round(($completedLessons / $totalLessons) * 100) : 0;
        
        $enrollment->pivot->update([
            'progress' => $progress,
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'progress' => $progress
        ]);
    }
}