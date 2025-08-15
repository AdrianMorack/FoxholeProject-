<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FoxholeSyncService;

class FoxholeUpdate extends Command
{
    protected $signature = 'foxhole:update';
    protected $description = 'Fetch Foxhole API and cache into MySQL';

    public function handle(FoxholeSyncService $sync)
    {
        $sync->run();
        $this->info('Foxhole data synced');
        return self::SUCCESS;
    }
}
