<?php

use App\Logging\IgraciasLogger;
use Illuminate\Support\Facades\Log;

if (!function_exists('logIgracias')) {
    /**
     * Log to igracias channel with consistent formatting.
     *
     * @param string $level Log level (info, error, warning, etc.)
     * @param string $message Message to log
     * @param array $context Additional context data
     * @return void
     */
    function logIgracias(string $level, string $message, array $context = []): void
    {
        Log::channel('igracias')->{$level}($message, $context);
    }
}

if (!function_exists('logIgraciasException')) {
    /**
     * Log exceptions in the standardized format for igracias.
     *
     * @param int $page Page number where the exception occurred
     * @param string $message Exception message
     * @param array $context Additional context data
     * @return void
     */
    function logIgraciasException(int $page, string $message, array $context = []): void
    {
        Log::channel('igracias')->error("Exception lain terjadi pada page {$page}");
        Log::channel('igracias')->error("error: {$message}");

        if (!empty($context)) {
            Log::channel('igracias')->error(json_encode($context));
        }
    }
}

if (!function_exists('createIgraciasLogger')) {
    /**
     * Create an IgraciasLogger instance.
     *
     * @param string $title Sync process title
     * @param string $batchId Batch ID for the sync process
     * @return IgraciasLogger
     */
    function createIgraciasLogger(string $title, string $batchId): IgraciasLogger
    {
        // Check if there's an existing logger in cache
        $cacheKey = "igracias_logger_{$batchId}";
        $logger = null;

        if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
            $logger = \Illuminate\Support\Facades\Cache::get($cacheKey);
        }

        if (!$logger) {
            $logger = new IgraciasLogger($title, $batchId);
            \Illuminate\Support\Facades\Cache::put($cacheKey, $logger, now()->addHours(1));
        }

        return $logger;
    }
}
