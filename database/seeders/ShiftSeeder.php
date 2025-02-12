<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ShiftSeeder extends Seeder
{
    public function run()
    {
        $users = User::role('healthcare_worker')->get();
        
        $departments = ['Emergency', 'ICU', 'Pediatrics', 'Surgery', 'General Ward'];
        $locations = ['North Wales Hospital', 'Liverpool Royal', 'Manchester General', 'Chester Medical Center'];
        $statuses = ['scheduled', 'in_progress', 'completed', 'cancelled'];
        
        foreach ($users as $user) {
            // Create past shifts
            for ($i = 0; $i < 5; $i++) {
                $startDate = Carbon::now()->subDays(rand(1, 30));
                $endDate = (clone $startDate)->addHours(rand(6, 12));
                
                Shift::create([
                    'user_id' => $user->id,
                    'start_datetime' => $startDate,
                    'end_datetime' => $endDate,
                    'location' => $locations[array_rand($locations)],
                    'department' => $departments[array_rand($departments)],
                    'status' => 'completed',
                    'rate_per_hour' => rand(15, 35),
                    'notes' => 'Completed shift',
                    'checkin_time' => $startDate,
                    'checkout_time' => $endDate,
                ]);
            }
            
            // Create upcoming shifts
            for ($i = 0; $i < 3; $i++) {
                $startDate = Carbon::now()->addDays(rand(1, 14));
                $endDate = (clone $startDate)->addHours(rand(6, 12));
                
                Shift::create([
                    'user_id' => $user->id,
                    'start_datetime' => $startDate,
                    'end_datetime' => $endDate,
                    'location' => $locations[array_rand($locations)],
                    'department' => $departments[array_rand($departments)],
                    'status' => 'scheduled',
                    'rate_per_hour' => rand(15, 35),
                    'notes' => 'Upcoming shift',
                ]);
            }

            // Create in-progress shifts (today)
            if (rand(0, 1)) {
                $startDate = Carbon::now()->subHours(rand(1, 4));
                $endDate = Carbon::now()->addHours(rand(4, 8));
                
                Shift::create([
                    'user_id' => $user->id,
                    'start_datetime' => $startDate,
                    'end_datetime' => $endDate,
                    'location' => $locations[array_rand($locations)],
                    'department' => $departments[array_rand($departments)],
                    'status' => 'in_progress',
                    'rate_per_hour' => rand(15, 35),
                    'notes' => 'Current shift',
                    'checkin_time' => $startDate,
                ]);
            }

            // Create some cancelled shifts
            for ($i = 0; $i < 2; $i++) {
                $startDate = Carbon::now()->addDays(rand(1, 30));
                $endDate = (clone $startDate)->addHours(rand(6, 12));
                
                Shift::create([
                    'user_id' => $user->id,
                    'start_datetime' => $startDate,
                    'end_datetime' => $endDate,
                    'location' => $locations[array_rand($locations)],
                    'department' => $departments[array_rand($departments)],
                    'status' => 'cancelled',
                    'rate_per_hour' => rand(15, 35),
                    'notes' => 'Cancelled due to ' . ['staff illness', 'department changes', 'scheduling conflict'][rand(0, 2)],
                ]);
            }
        }
    }
}
