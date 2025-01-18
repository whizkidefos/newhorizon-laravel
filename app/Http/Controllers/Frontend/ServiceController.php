<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        $services = [
            [
                'title' => 'Registered Nurses',
                'description' => 'Experienced nursing professionals providing high-quality patient care.',
                'features' => [
                    'Emergency and Critical Care',
                    'Medical-Surgical Units',
                    'Long-term Care',
                    'Mental Health Services'
                ],
                'icon' => 'nurse'
            ],
            [
                'title' => 'Healthcare Assistants',
                'description' => 'Dedicated support staff ensuring patient comfort and care.',
                'features' => [
                    'Patient Personal Care',
                    'Vital Signs Monitoring',
                    'Medication Assistance',
                    'Daily Living Support'
                ],
                'icon' => 'healthcare'
            ],
            [
                'title' => 'Support Workers',
                'description' => 'Professional care workers supporting various healthcare environments.',
                'features' => [
                    'Residential Care Support',
                    'Community Care',
                    'Rehabilitation Support',
                    'Social Care Assistance'
                ],
                'icon' => 'support'
            ]
        ];

        return view('frontend.services', compact('services'));
    }
}