<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // Create a basic healthcare course
        $course = Course::create([
            'title' => 'Basic Healthcare Training',
            'description' => 'Essential training for healthcare professionals covering patient care, safety protocols, and basic medical procedures.',
            'price' => 199.99,
            'duration' => 20,
            'status' => 'active',
            'requirements' => '- Basic understanding of healthcare\n- Commitment to patient care\n- Good communication skills',
            'what_you_will_learn' => '- Patient care fundamentals\n- Safety protocols\n- Basic medical procedures\n- Healthcare ethics',
            'is_featured' => true
        ]);

        // Create modules for the course
        $modules = [
            [
                'title' => 'Introduction to Healthcare',
                'description' => 'Basic concepts and principles of healthcare',
                'lessons' => [
                    [
                        'title' => 'Healthcare System Overview',
                        'description' => 'Understanding the healthcare system structure',
                        'duration' => 30
                    ],
                    [
                        'title' => 'Patient Care Basics',
                        'description' => 'Fundamental aspects of patient care',
                        'duration' => 45
                    ]
                ]
            ],
            [
                'title' => 'Safety Protocols',
                'description' => 'Essential safety procedures in healthcare',
                'lessons' => [
                    [
                        'title' => 'Infection Control',
                        'description' => 'Understanding and implementing infection control measures',
                        'duration' => 60
                    ],
                    [
                        'title' => 'Personal Protective Equipment',
                        'description' => 'Proper use of PPE in healthcare settings',
                        'duration' => 30
                    ]
                ]
            ]
        ];

        foreach ($modules as $index => $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title'],
                'description' => $moduleData['description'],
                'order' => $index + 1
            ]);

            foreach ($moduleData['lessons'] as $lessonIndex => $lessonData) {
                $module->lessons()->create([
                    'title' => $lessonData['title'],
                    'description' => $lessonData['description'],
                    'duration' => $lessonData['duration'],
                    'order' => $lessonIndex + 1
                ]);
            }
        }

        // Create an advanced course
        $course = Course::create([
            'title' => 'Advanced Clinical Skills',
            'description' => 'Advanced training for healthcare professionals focusing on specialized clinical procedures and patient management.',
            'price' => 299.99,
            'duration' => 30,
            'status' => 'active',
            'requirements' => '- Basic healthcare certification\n- Minimum 1 year experience\n- Current healthcare employment',
            'what_you_will_learn' => '- Advanced clinical procedures\n- Complex patient management\n- Emergency response\n- Leadership in healthcare',
            'is_featured' => false
        ]);

        // Create modules for the advanced course
        $modules = [
            [
                'title' => 'Advanced Clinical Procedures',
                'description' => 'Complex clinical procedures and techniques',
                'lessons' => [
                    [
                        'title' => 'Advanced Patient Assessment',
                        'description' => 'Comprehensive patient assessment techniques',
                        'duration' => 60
                    ],
                    [
                        'title' => 'Complex Care Procedures',
                        'description' => 'Managing complex care scenarios',
                        'duration' => 90
                    ]
                ]
            ],
            [
                'title' => 'Emergency Response',
                'description' => 'Advanced emergency response procedures',
                'lessons' => [
                    [
                        'title' => 'Emergency Protocol Implementation',
                        'description' => 'Managing emergency situations effectively',
                        'duration' => 75
                    ],
                    [
                        'title' => 'Crisis Management',
                        'description' => 'Leadership during healthcare crises',
                        'duration' => 60
                    ]
                ]
            ]
        ];

        foreach ($modules as $index => $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title'],
                'description' => $moduleData['description'],
                'order' => $index + 1
            ]);

            foreach ($moduleData['lessons'] as $lessonIndex => $lessonData) {
                $module->lessons()->create([
                    'title' => $lessonData['title'],
                    'description' => $lessonData['description'],
                    'duration' => $lessonData['duration'],
                    'order' => $lessonIndex + 1
                ]);
            }
        }
    }
}
