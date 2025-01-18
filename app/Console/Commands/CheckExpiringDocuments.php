<?php

namespace App\Console\Commands;

use App\Models\DocumentVerification;
use App\Notifications\DocumentExpiryNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiringDocuments extends Command
{
    protected $signature = 'documents:check-expiring';
    protected $description = 'Check for documents expiring soon';

    public function handle()
    {
        $expiringDate = Carbon::now()->addDays(30);

        $expiringVerifications = DocumentVerification::with(['document.user'])
            ->where('status', 'approved')
            ->where('expires_at', '<=', $expiringDate)
            ->where('expires_at', '>', Carbon::now())
            ->whereDoesntHave('notifications', function($query) {
                $query->where('created_at', '>', Carbon::now()->subDays(7));
            })
            ->get();

        foreach ($expiringVerifications as $verification) {
            $verification->document->user->notify(
                new DocumentExpiryNotification($verification)
            );
        }

        $this->info("Notified users about {$expiringVerifications->count()} expiring documents.");
    }
}