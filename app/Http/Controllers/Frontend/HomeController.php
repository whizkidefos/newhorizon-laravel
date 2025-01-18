<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home', [
            'featuredJobs' => $this->getFeaturedJobs(),
            'testimonials' => $this->getTestimonials()
        ]);
    }

    private function getFeaturedJobs()
    {
        return \App\Models\Shift::where('status', 'open')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    }

    private function getTestimonials()
    {
        return [
            [
                'name' => 'Sarah Johnson',
                'role' => 'Registered Nurse',
                'content' => 'New Horizon Healthcare has been instrumental in advancing my nursing career...'
            ],
            [
                'name' => 'John Doe',
                'role' => 'Healthcare Assistant',
                'content' => 'I have been working with New Horizon Healthcare for over 5 years now and I am very happy with the support and opportunities...'
            ],
            [
                'name' => 'Jane Smith',
                'role' => 'Support Worker',
                'content' => 'I have been working with New Horizon Healthcare for over 5 years now and I am very happy with the support and opportunities...'
            ],
            [
                'name' => 'Alice Brown',
                'role' => 'Registered Nurse',
                'content' => 'New Horizon Healthcare has been instrumental in advancing my nursing career...'
            ],
            // Add more testimonials...
        ];
    }
}