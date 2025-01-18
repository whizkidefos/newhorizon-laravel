<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', 'active')->paginate(12);
        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
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
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Successfully enrolled in course.');
    }
}