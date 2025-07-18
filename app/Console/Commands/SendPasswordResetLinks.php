<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Password;

class SendPasswordResetLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:send-reset-links {--email= : Send to a specific email} {--all : Send to all users without password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send password reset links to imported users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $all = $this->option('all');
        
        if (!$email && !$all) {
            $this->error('Please specify either --email or --all option');
            return 1;
        }
        
        if ($email) {
            $user = User::where('email', $email)->first();
            
            if (!$user) {
                $this->error("User with email {$email} not found");
                return 1;
            }
            
            $this->sendResetLink($user);
            $this->info("Password reset link sent to {$email}");
        } else {
            $query = User::whereNull('password')
                ->orWhere('password', '');
                
            $count = $query->count();
            
            if ($count === 0) {
                $this->info('No users found that need password reset links');
                return 0;
            }
            
            $this->info("Sending password reset links to {$count} users...");
            
            $bar = $this->output->createProgressBar($count);
            $bar->start();
            
            $query->chunk(100, function ($users) use ($bar) {
                foreach ($users as $user) {
                    $this->sendResetLink($user);
                    $bar->advance();
                }
            });
            
            $bar->finish();
            $this->newLine();
            $this->info("Password reset links sent to {$count} users");
        }
        
        return 0;
    }
    
    /**
     * Send a password reset link to the user.
     */
    protected function sendResetLink(User $user)
    {
        Password::sendResetLink(['email' => $user->email]);
    }
}
