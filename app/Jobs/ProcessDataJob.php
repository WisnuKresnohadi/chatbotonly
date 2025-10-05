<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected array $data;
    protected string $batchId;
    protected string $syncClass;

    public function __construct(array $data, string $batchId, string $syncClass)
    {
        $this->data = $data;
        $this->batchId = $batchId;
        $this->syncClass = $syncClass;
    }

    public function handle()
    {
        if ($this->batch() && $this->batch()->cancelled()) {
            return;
        }

        try {
            // ✅ Gunakan syncClass untuk memproses data
            $syncInstance = app($this->syncClass);
            $syncInstance->processData($this->data);

            Log::info("Memproses data dalam batch {$this->batchId} dengan class {$this->syncClass}");
        } catch (\Exception $e) {
            Log::error("ProcessDataJob failed: " . $e->getMessage());
        }
    }
}
