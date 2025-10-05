<?php

namespace App\Jobs;

use App\Sync\BaseSynchronize;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProcessSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $retryAfter = 900;

    protected $synchronizeInstance;
    /**
     * Create a new job instance.
     */
    public function __construct(BaseSynchronize $synchronizeInstance)
    {
        $this->synchronizeInstance = $synchronizeInstance;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info("ProcessSyncJob: Starting synchronization.");            
            $this->synchronizeInstance->synchronize();
            Log::info("ProcessSyncJob: Synchronization completed successfully.");  
            Cache::lock('sync-lock')->release();          
        } catch (Exception $e) {             
            Cache::lock('sync-lock')->release();                 
            Log::error("ProcessSyncJob Error: " . $e->getMessage());
            throw $e;
        }
    }
}
