<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportWordPressUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:import-wordpress {--connection=wordpress}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from WordPress with Ultimate Member plugin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting WordPress user import...');
        
        // Get connection name from options
        $connection = $this->option('connection');
        
        // Check if the connection exists
        if (!config("database.connections.$connection")) {
            $this->error("Database connection '$connection' not found!");
            
            // Ask for WordPress database credentials
            $this->info('Please provide WordPress database credentials:');
            $host = $this->ask('Database host', '127.0.0.1');
            $port = $this->ask('Database port', '3306');
            $database = $this->ask('Database name');
            $username = $this->ask('Database username');
            $password = $this->secret('Database password');
            $prefix = $this->ask('Table prefix', 'wp_');
            
            // Configure the WordPress database connection
            config([
                "database.connections.$connection" => [
                    'driver' => 'mysql',
                    'host' => $host,
                    'port' => $port,
                    'database' => $database,
                    'username' => $username,
                    'password' => $password,
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => $prefix,
                    'strict' => false,
                ]
            ]);
        }
        
        try {
            // Test the connection
            DB::connection($connection)->getPdo();
            $this->info("Connection to WordPress database established successfully.");
        } catch (\Exception $e) {
            $this->error("Failed to connect to WordPress database: " . $e->getMessage());
            return 1;
        }
        
        // Get WordPress users
        $wpUsers = DB::connection($connection)
            ->table('users')
            ->select([
                'users.ID as id',
                'users.user_login as username',
                'users.user_email as email',
                'users.user_registered as registered_at',
                'users.display_name as display_name',
            ])
            ->get();
        
        $this->info("Found {$wpUsers->count()} WordPress users.");
        
        // Get WordPress user meta
        $userCount = 0;
        $errorCount = 0;
        
        $bar = $this->output->createProgressBar($wpUsers->count());
        $bar->start();
        
        foreach ($wpUsers as $wpUser) {
            try {
                // Get user meta
                $userMeta = DB::connection($connection)
                    ->table('usermeta')
                    ->where('user_id', $wpUser->id)
                    ->get()
                    ->keyBy('meta_key')
                    ->map(function ($item) {
                        return $item->meta_value;
                    });
                
                // Extract Ultimate Member fields
                $firstName = $userMeta['first_name'] ?? ($userMeta['um_first_name'] ?? '');
                $lastName = $userMeta['last_name'] ?? ($userMeta['um_last_name'] ?? '');
                $phone = $userMeta['phone_number'] ?? ($userMeta['um_phone_number'] ?? '');
                
                // Check if user already exists
                $existingUser = User::where('email', $wpUser->email)->first();
                
                if ($existingUser) {
                    // Update existing user
                    $existingUser->update([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'phone' => $phone,
                    ]);
                } else {
                    // Create new user
                    User::create([
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $wpUser->email,
                        'email_verified_at' => now(),
                        'phone' => $phone,
                        'password' => Hash::make(Str::random(16)), // Random password
                        'remember_token' => Str::random(10),
                    ]);
                    
                    $userCount++;
                }
            } catch (\Exception $e) {
                $this->error("Error importing user {$wpUser->email}: " . $e->getMessage());
                $errorCount++;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $this->info("Import completed. Imported $userCount new users with $errorCount errors.");
        
        return 0;
    }
}
