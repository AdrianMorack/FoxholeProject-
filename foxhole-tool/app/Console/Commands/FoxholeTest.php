<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FoxholeTest extends Command
{
    protected $signature = 'foxhole:test';
    protected $description = 'Test if Foxhole API is responding';

    public function handle()
    {
        $this->info('Testing Foxhole API...');
        
        $start = microtime(true);
        
        try {
            $response = Http::timeout(30)->get('https://war-service-live-2.foxholeservices.com/api/worldconquest/war');
            $duration = round((microtime(true) - $start) * 1000);
            
            if ($response->successful()) {
                $this->info("✓ API is UP! Response time: {$duration}ms");
                $this->info("War ID: " . ($response->json()['warId'] ?? 'unknown'));
                return self::SUCCESS;
            } else {
                $this->error("✗ API returned status: " . $response->status());
                return self::FAILURE;
            }
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $start) * 1000);
            $this->error("✗ API is DOWN or SLOW after {$duration}ms");
            $this->error("Error: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
