<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowPasswordResetLinks extends Command
{
    protected $signature = 'password:show-links {--email= : Filter by specific email}';
    protected $description = 'Show password reset links from logs (for development)';

    public function handle()
    {
        $logPath = storage_path('logs/laravel.log');
        
        if (!file_exists($logPath)) {
            $this->error('No log file found at: ' . $logPath);
            return 1;
        }

        $content = file_get_contents($logPath);
        $email = $this->option('email');
        
        // Find all reset password URLs
        preg_match_all('/http:\/\/localhost:8000\/reset-password\/[a-f0-9]+\?email=[^">\s]+/', $content, $matches);
        
        if (empty($matches[0])) {
            $this->info('No password reset links found in logs.');
            return 0;
        }

        $links = array_reverse(array_unique($matches[0])); // Most recent first, remove duplicates
        
        $this->info('🔗 Password Reset Links Found:');
        $this->newLine();
        
        foreach ($links as $index => $link) {
            // Extract email from URL
            if (preg_match('/email=([^&]+)/', $link, $emailMatch)) {
                $linkEmail = urldecode($emailMatch[1]);
                
                // Filter by email if specified
                if ($email && $linkEmail !== $email) {
                    continue;
                }
                
                $this->line('<fg=cyan>' . ($index + 1) . '.</> <fg=yellow>' . $linkEmail . '</>');
                $this->line('<fg=green>' . $link . '</>');
                $this->newLine();
            }
        }
        
        $this->info('💡 Copy any link above and paste it in your browser to reset the password.');
        
        return 0;
    }
} 