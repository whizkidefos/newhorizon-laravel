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
        $courses = [
            [
                'title' => 'Basic Healthcare Training',
                'description' => 'Essential training for healthcare professionals covering patient care, safety protocols, and basic medical procedures.',
                'price' => 199.99,
                'duration' => 20,
                'status' => 'active',
                'requirements' => '- Basic understanding of healthcare\n- Commitment to patient care\n- Good communication skills',
                'what_you_will_learn' => '- Patient care fundamentals\n- Safety protocols\n- Basic medical procedures\n- Healthcare ethics',
                'is_featured' => true
            ],
            [
                'title' => 'Advanced Clinical Skills',
                'description' => 'Comprehensive training in advanced clinical procedures and patient management.',
                'price' => 299.99,
                'duration' => 30,
                'status' => 'active',
                'requirements' => '- Basic Healthcare Training completion\n- Minimum 1 year experience\n- Current healthcare certification',
                'what_you_will_learn' => '- Advanced clinical procedures\n- Complex patient management\n- Emergency response\n- Leadership in healthcare',
                'is_featured' => true
            ],
            [
                'title' => 'Mental Health First Aid',
                'description' => 'Essential training for supporting individuals with mental health challenges.',
                'price' => 149.99,
                'duration' => 15,
                'status' => 'active',
                'requirements' => '- No prior experience required\n- Interest in mental health support\n- Empathetic approach',
                'what_you_will_learn' => '- Mental health awareness\n- Crisis intervention\n- Support strategies\n- Resource navigation',
                'is_featured' => false
            ],
            [
                'title' => 'Infection Control Specialist',
                'description' => 'Specialized training in infection prevention and control measures.',
                'price' => 249.99,
                'duration' => 25,
                'status' => 'active',
                'requirements' => '- Healthcare background\n- Basic microbiology knowledge\n- Attention to detail',
                'what_you_will_learn' => '- Advanced infection control\n- Sterilization techniques\n- Risk assessment\n- Policy development',
                'is_featured' => true
            ]
        ];

        foreach ($courses as $courseData) {
            $course = Course::create($courseData);
            
            // Create modules for each course
            $modules = [
                [
                    'title' => 'Introduction and Fundamentals',
                    'description' => 'Basic concepts and principles',
                    'order' => 1,
                    'lessons' => [
                        [
                            'title' => 'Course Overview',
                            'description' => 'Understanding the course structure and objectives',
                            'duration' => 30,
                            'order' => 1
                        ],
                        [
                            'title' => 'Core Concepts',
                            'description' => 'Fundamental principles and terminology',
                            'duration' => 45,
                            'order' => 2
                        ]
                    ]
                ],
                [
                    'title' => 'Practical Applications',
                    'description' => 'Hands-on practice and real-world scenarios',
                    'order' => 2,
                    'lessons' => [
                        [
                            'title' => 'Case Studies',
                            'description' => 'Real-world examples and analysis',
                            'duration' => 60,
                            'order' => 1
                        ],
                        [
                            'title' => 'Practical Exercises',
                            'description' => 'Hands-on practice sessions',
                            'duration' => 90,
                            'order' => 2
                        ]
                    ]
                ],
                [
                    'title' => 'Advanced Topics',
                    'description' => 'In-depth exploration of specialized areas',
                    'order' => 3,
                    'lessons' => [
                        [
                            'title' => 'Specialized Techniques',
                            'description' => 'Advanced methods and procedures',
                            'duration' => 75,
                            'order' => 1
                        ],
                        [
                            'title' => 'Industry Best Practices',
                            'description' => 'Current standards and recommendations',
                            'duration' => 60,
                            'order' => 2
                        ]
                    ]
                ]
            ];

            foreach ($modules as $moduleData) {
                $lessons = $moduleData['lessons'];
                unset($moduleData['lessons']);
                
                $module = $course->modules()->create($moduleData);
                
                foreach ($lessons as $lessonData) {
                    $module->lessons()->create($lessonData);
                }
            }
        }
    }
}
