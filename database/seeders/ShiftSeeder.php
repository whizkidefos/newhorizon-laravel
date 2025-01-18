<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            'Chester Hospital',
            'Liverpool Care Home',
            'Manchester Medical Center',
            'Wrexham Hospital',
            'Birkenhead Clinic'
        ];

        for ($i = 0; $i < 20; $i++) {
            $startDate = now()->addDays(rand(1, 30))->setHour(rand(6, 18));
            
            Shift::create([
                'start_datetime' => $startDate,
                'end_datetime' => $startDate->copy()->addHours(8),
                'location' => $locations[array_rand($locations)],
                'status' => 'open',
                'rate_per_hour' => rand(15, 25),
                'notes' => 'Regular shift with standard responsibilities'
            ]);
        }
    }
}