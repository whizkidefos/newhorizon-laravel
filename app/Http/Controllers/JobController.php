<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->paginate(12);
        return view('jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        $relatedJobs = Job::where('id', '!=', $job->id)
            ->where(function($query) use ($job) {
                $query->where('type', $job->type)
                    ->orWhere('location', $job->location);
            })
            ->take(3)
            ->get();

        return view('jobs.show', compact('job', 'relatedJobs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $jobs = Job::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('location', 'like', "%{$query}%")
            ->latest()
            ->paginate(12);

        return view('jobs.index', compact('jobs', 'query'));
    }
}
