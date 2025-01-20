<?php

namespace App\Jobs;

use App\Models\Shift;
use App\Notifications\ShiftReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendShiftReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Get all shifts starting tomorrow
        $shifts = Shift::query()
            ->where('status', 'assigned')
            ->whereBetween('start_datetime', [
                now()->addDay()->startOfDay(),
                now()->addDay()->endOfDay()
            ])
            ->with('user')
            ->get();

        foreach ($shifts as $shift) {
            if ($shift->user) {
                $shift->user->notify(new ShiftReminder($shift));
            }
        }
    }
}