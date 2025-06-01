<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-user-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote a user role to "admin" by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $email = $this->argument('email');
            $user = User::where('email', $email)->firstOrFail();

            if ($user->role === 'admin') {
                $this->info("User {$email} is already an admin.");
                return Command::SUCCESS;
            }

            $user->update(['role' => 'admin']);
            $this->info("User {$email} is now an admin.");
            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
