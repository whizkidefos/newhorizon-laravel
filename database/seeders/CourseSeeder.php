<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $courses = [
            [
                'name' => 'COSHH Training',
                'description' => 'Control of Substances Hazardous to Health training course',
                'price' => 49.99,
                'duration_hours' => 3,
            ],
            [
                'name' => 'Manual Handling',
                'description' => 'Safe manual handling practices in healthcare settings',
                'price' => 39.99,
                'duration_hours' => 4,
            ],
            [
                'name' => 'Infection Control',
                'description' => 'Essential infection prevention and control measures',
                'price' => 59.99,
                'duration_hours' => 5,
            ],
        ];

        foreach ($courses as $course) {
            Course::create([
                'name' => $course['name'],
                'description' => $course['description'],
                'price' => $course['price'],
                'duration_hours' => $course['duration_hours'],
                'status' => 'active'
            ]);
        }
    }
}