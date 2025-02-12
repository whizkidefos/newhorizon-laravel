<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'requirements' => 'nullable|string',
            'what_you_will_learn' => 'nullable|string',
            'is_featured' => 'boolean'
        ]);

        Course::create($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully');
    }

    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'requirements' => 'nullable|string',
            'what_you_will_learn' => 'nullable|string',
            'is_featured' => 'boolean'
        ]);

        $course->update($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully');
    }

    public function enrollments(Course $course)
    {
        $enrollments = $course->users()->paginate(10);
        return view('admin.courses.enrollments', compact('course', 'enrollments'));
    }
}