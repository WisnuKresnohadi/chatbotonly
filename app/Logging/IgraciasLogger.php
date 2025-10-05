<?php

namespace App\Logging;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class IgraciasLogger
{
    protected string $key;
    protected string $title;
    protected string $cacheKey;
    protected string $batchId;

    public function __construct(string $title, string $batchId = '')
    {
        $this->title = $title;
        $this->batchId = $batchId ?: Str::random(6);
        $this->key = Str::slug($title) . '-' . now()->format('Ymd-His');
        $this->cacheKey = "sync_log_{$this->key}";
        $this->reset();
    }

    // Store and retrieve logger state from a single cache entry
    public function getState(): array
    {
        return Cache::get($this->cacheKey . '_state', [
            'hasStarted' => false,
            'hasError' => false,
            'totalData' => 0,
            'successCount' => 0,
            'errorCount' => 0,
            'errorPages' => [],
            'lastPageNum' => 0,
            'currentPage' => 0,
            'logs' => [],
            // Batch related metrics
            'batchSuccess' => 0,
            'batchFailed' => 0,
            'batchTotal' => 0,
            'batchPaginateTotal' => 0,
            // Timing information
            'executionTime' => 0,
            // Track metrics by sync type
            'syncTypes' => []
        ]);
    }

    public function setState(array $state): void
    {
        Cache::put($this->cacheKey . '_state', $state, now()->addHours(1));
    }

    protected function updateState(array $updates): void
    {
        $state = $this->getState();
        $state = array_merge($state, $updates);
        $this->setState($state);
    }

    // Helper methods to get/set specific state properties
    protected function getHasStarted(): bool
    {
        return $this->getState()['hasStarted'];
    }

    protected function setHasStarted(bool $value): void
    {
        $this->updateState(['hasStarted' => $value]);
    }

    protected function getHasError(): bool
    {
        return $this->getState()['hasError'];
    }

    protected function setHasError(bool $value): void
    {
        $this->updateState(['hasError' => $value]);
    }

    public function start(array $firstResponse = []): void
    {
        // Get the current sync type from the title or use a default
        $syncType = $this->title ?? 'Unknown';

        // Each sync process should have its own started flag
        $state = $this->getState();
        $allSyncTypes = $state['syncTypes'] ?? [];

        // If this is a new sync type, initialize its metrics
        if (!isset($allSyncTypes[$syncType])) {
            $allSyncTypes[$syncType] = [
                'hasStarted' => false,
                'totalData' => 0,
                'successCount' => 0,
                'errorCount' => 0,
            ];
        }

        // Only log the start once per sync type
        if ($allSyncTypes[$syncType]['hasStarted']) {
            return;
        }

        $allSyncTypes[$syncType]['hasStarted'] = true;
        $state['syncTypes'] = $allSyncTypes;
        $this->setState($state);

        // Make sure we capture total data from first response
        if (isset($firstResponse['paginate']) && isset($firstResponse['paginate']['total'])) {
            $totalData = (int)$firstResponse['paginate']['total'];

            // Update both the overall state and the sync-specific state
            $state = $this->getState();
            $allSyncTypes = $state['syncTypes'] ?? [];
            $allSyncTypes[$syncType]['totalData'] = $totalData;
            $state['syncTypes'] = $allSyncTypes;

            // Also update batch totals
            $currentTotal = $state['batchTotal'] ?? 0;
            $state['batchTotal'] = $currentTotal + $totalData;

            $this->setState($state);

            // Ensure it's also in cache for backward compatibility
            $existingTotal = Cache::get("batch_{$this->batchId}_total", 0);
            Cache::put("batch_{$this->batchId}_total", $existingTotal + $totalData, now()->addHours(1));
        }

        $this->logRaw("---------------------- Sinkronisasi data {$this->title} Dimulai ----------------------");
        $this->logRaw("batch_id: {$this->batchId}");

        if (is_array($firstResponse)) {
            $errorValue = isset($firstResponse['error']) ?
                ($firstResponse['error'] === true || $firstResponse['error'] === 1 ? 'true' : 'false') :
                'false';

            if ($errorValue === 'true') {
                $this->setHasError(true);
            }
        }

        $this->logRaw(""); // untuk enter
    }

    public function logPaginationDetail($firstResponse)
    {
        if (isset($firstResponse['paginate'])) {

            if (is_array($firstResponse)) {
                $errorValue = isset($firstResponse['error']) ?
                    ($firstResponse['error'] === true || $firstResponse['error'] === 1 ? 'true' : 'false') :
                    'false';

                if ($errorValue === 'true') {
                    $this->setHasError(true);
                }
            }

            $this->logRaw("error : {$errorValue},");
            $this->logRaw("code : " . ($firstResponse['code'] ?? 200) . ",");
            $this->logRaw("message : " . ($firstResponse['message'] ?? 'Data berhasil diambil.') . ",");

            $this->logRaw("paginate : {");
            $this->logRaw("    current_page : " . ($firstResponse['paginate']['current_page'] ?? 1) . ",");
            $this->logRaw("    last_page : " . ($firstResponse['paginate']['last_page'] ?? 1) . ",");
            $this->logRaw("    per_page : " . ($firstResponse['paginate']['per_page'] ?? 10) . ",");
            $this->logRaw("    total : " . ($firstResponse['paginate']['total'] ?? 0));
            $this->logRaw("}");
            $this->logRaw(""); // untuk enter
        }
    }

    public function logPage(int $page, string $syncName, array $response): void
    {
        // Update the current page in state
        $state = $this->getState();
        $state['currentPage'] = $page;
        $this->setState($state);

        $this->logRaw("Mengambil data {$syncName} pada page {$page}");

        if (!empty($response)) {
            // Convert boolean error to string representation
            $errorValue = isset($response['error']) ?
                ($response['error'] === true || $response['error'] === 1 ? 'true' : 'false') :
                'false';

            $this->logRaw("error : {$errorValue},");
            $this->logRaw("code : " . ($response['code'] ?? 200));
            $this->logRaw("message : " . ($response['message'] ?? 'Data berhasil diambil.') . ",");
            $this->logRaw("total data page {$page} : " . count($response['data'] ?? []));
            $this->logRaw("");

            // If there's an error, mark it
            if ($errorValue === 'true') {
                $this->setHasError(true);
            }
        }

        // Update success count if successful
        if (isset($response['data']) && !($response['error'] ?? false)) {
            $state = $this->getState();
            $state['successCount'] += count($response['data'] ?? []);
            $this->setState($state);
        }
    }

    /**
     * Helper method to check if an error is already logged
     */
    protected function isErrorDuplicate(array $newError, array $existingErrors): bool
    {
        foreach ($existingErrors as $error) {
            if (
                $error['id_job'] === $newError['id_job'] &&
                $error['page'] === $newError['page'] &&
                $error['error'] === $newError['error']
            ) {
                return true;
            }
        }
        return false;
    }

    public function logRetry(int $page, int $attempt, string $syncName, array $response): void
    {
        $this->logRaw("Pengulangan pengambilan data {$syncName} pada page {$page}");

        // Convert boolean error to string representation
        $errorValue = isset($response['error']) ?
            ($response['error'] === true || $response['error'] === 1 ? 'true' : 'false') :
            'false';

        $this->logRaw("error: {$errorValue}");
        $this->logRaw("code: " . ($response['code'] ?? 500));
        $this->logRaw("message: " . ($response['message'] ?? 'Unknown error'));
        $this->logRaw("");

        // Mark that we had an error
        if ($errorValue === 'true') {
            $this->setHasError(true);

            $state = $this->getState();

            $newError = [
                'page' => $page,
                'id_job' => $this->batchId,
                'error' => $response['message'] ?? 'Unknown error'
            ];

            // Only add if it's not a duplicate
            if (!$this->isErrorDuplicate($newError, $state['errorPages'])) {
                $state['errorPages'][] = $newError;
            }

            $state['errorCount'] += count($response['data'] ?? []);
            $this->setState($state);
        }
    }

    public function logException(string $message, int $page = 0): void
    {
        $state = $this->getState();

        // Use the current page from state if provided page is 0
        if ($page == 0) {
            $page = $state['currentPage'] > 0 ? $state['currentPage'] : 1;
        }

        $newError = [
            'page' => $page,
            'id_job' => $this->batchId,
            'error' => $message,
        ];

        if (!$this->isErrorDuplicate($newError, $state['errorPages'])) {
            $state['errorPages'][] = $newError;
        }


        $state['hasError'] = true;
        $this->setState($state);
        $this->setHasError(true);


        Cache::put("batch_{$this->batchId}_error", [
            'error' => true,
            'message' => $message
        ], now()->addHours(1));


        // Log the exception with the proper page number
        $this->logError("Exception lain terjadi pada page {$page}");
        $this->logError("error: {$message}");
        $this->logError("");



        $state['errorCount'] += 1;
        $this->setState($state);


        $this->incrementBatchFailed(1);
    }


    protected function logError(string $message): void
    {
        $state = $this->getState();
        $state['logs'][] = $message;
        $this->setState($state);

        Log::channel('igracias')->error($message);
    }

    public function logSuccess(int $dataCount): void
    {
        $state = $this->getState();
        $state['successCount'] += $dataCount;
        $this->setState($state);
    }

    public function setLastPageNum(int $lastPageNum): void
    {
        $state = $this->getState();
        $state['lastPageNum'] = $lastPageNum;
        $this->setState($state);
    }

    public function incrementErrorCount(int $count = 1): void
    {
        $syncType = $this->title ?? 'Unknown';

        $state = $this->getState();
        $allSyncTypes = $state['syncTypes'] ?? [];

        if (!isset($allSyncTypes[$syncType])) {
            $allSyncTypes[$syncType] = [
                'hasStarted' => true,
                'totalData' => 0,
                'successCount' => 0,
                'errorCount' => 0,
            ];
        }

        $allSyncTypes[$syncType]['errorCount'] += $count;
        $state['syncTypes'] = $allSyncTypes;
        $this->setState($state);

        if ($count > 0) {
            $this->setHasError(true);
            $this->incrementBatchFailed($count);
        }
    }

    public function incrementSuccessCount(int $count = 1): void
    {
        $syncType = $this->title ?? 'Unknown';

        $state = $this->getState();
        $allSyncTypes = $state['syncTypes'] ?? [];

        if (!isset($allSyncTypes[$syncType])) {
            $allSyncTypes[$syncType] = [
                'hasStarted' => true,
                'totalData' => 0,
                'successCount' => 0,
                'errorCount' => 0,
            ];
        }

        $allSyncTypes[$syncType]['successCount'] += $count;
        $state['syncTypes'] = $allSyncTypes;
        $this->setState($state);

        // Also increment batch success
        $this->incrementBatchSuccess($count);
    }

    public function incrementBatchSuccess(int $count = 1): void
    {
        $state = $this->getState();
        $state['batchSuccess'] += $count;
        $this->setState($state);

        // Also maintain compatibility with old code that might still check the old cache key
        $currentSuccess = Cache::get("batch_{$this->batchId}_success", 0);
        Cache::put("batch_{$this->batchId}_success", $currentSuccess + $count, now()->addHours(1));
    }

    public function incrementBatchFailed(int $count = 1): void
    {
        $state = $this->getState();

        // Prevent accumulating too many failed counts when retrying
        if ($state['batchFailed'] < $state['totalData']) {
            $state['batchFailed'] += $count;
        }

        $this->setState($state);

        // Also maintain compatibility with old code that might still check the old cache key
        $currentFailed = Cache::get("batch_{$this->batchId}_failed", 0);

        // Prevent overcounting failures
        if ($currentFailed < $state['totalData']) {
            Cache::put("batch_{$this->batchId}_failed", $currentFailed + $count, now()->addHours(1));
        }
    }

    public function setBatchTotal(int $total): void
    {
        $state = $this->getState();
        $state['batchTotal'] = $total;
        $state['batchPaginateTotal'] = $total;
        $state['totalData'] = $total; // Ensure totalData is also updated
        $this->setState($state);

        // Also maintain compatibility with old code
        Cache::put("batch_{$this->batchId}_total", $total, now()->addHours(1));
        Cache::put("batch_{$this->batchId}_paginate_total", $total, now()->addHours(1));
    }

    public function end(): void
    {
        $syncType = $this->title ?? 'Unknown';
        $state = $this->getState();
        $allSyncTypes = $state['syncTypes'] ?? [];

        // Get metrics for the current sync type
        $syncTypeMetrics = $allSyncTypes[$syncType] ?? [
            'totalData' => 0,
            'successCount' => 0,
            'errorCount' => 0
        ];

        // Check if there are any error pages or if the error flag is set
        $hasError = $this->getHasError() || count($state['errorPages']) > 0;

        // Also check the specific batch error cache
        $batchErrorInfo = Cache::get("batch_{$this->batchId}_error", ['error' => false]);
        if ($batchErrorInfo['error']) {
            $hasError = true;
        }

        // Use the error flag to determine the status
        $status = $hasError ? 'GAGAL' : 'BERHASIL';

        $this->logRaw("status: {$status}");
        $this->logRaw("detail error page:");

        if (count($state['errorPages']) > 0) {
            $this->logRaw("[");
            // Get unique error pages to prevent duplicates
            $uniqueErrors = $state['errorPages'];
            foreach ($uniqueErrors as $idx => $err) {
                $this->logRaw("    " . ($idx + 1) . ": [");
                $this->logRaw("        page: {$err['page']},");
                $this->logRaw("        id_job: {$err['id_job']},");
                $this->logRaw("        error: \"{$err['error']}\"");
                $this->logRaw("    ]" . ($idx < count($uniqueErrors) - 1 ? "," : ""));
            }
            $this->logRaw("]");
        } else {
            $this->logRaw("[]");
        }

        // Report metrics for the current sync type only
        $totalData = $syncTypeMetrics['successCount'] + $syncTypeMetrics['errorCount'];
        $successCount = $syncTypeMetrics['successCount'];
        $errorCount = $syncTypeMetrics['errorCount'];

        // If no data in syncTypeMetrics, use batch metrics which might be more accurate
        if ($totalData == 0 && $successCount == 0 && $errorCount == 0) {
            $totalData = $state['batchTotal'] ?: $state['totalData'];
            $successCount = $state['batchSuccess'];
            $errorCount = $state['batchFailed'];
        }

        // If the success count exceeds total data, update the total data
        if (($successCount + $errorCount) > $totalData) {
            $totalData = $successCount + $errorCount;
        }

        // Ensure we have at least some total if we have successful or failed items
        if ($totalData == 0 && ($successCount > 0 || $errorCount > 0)) {
            $totalData = $successCount + $errorCount;
        }

        $this->logRaw("total data: {$totalData}");
        $this->logRaw("total data berhasil: {$successCount}");
        $this->logRaw("total data gagal: {$errorCount}");

        // Format execution time
        $executionTime = $state['executionTime'];
        if ($executionTime == 0) {
            // If not set in state, try to get from cache
            $endTime = Cache::get("batch_{$this->batchId}_end_time");
            $startTime = Cache::get("batch_{$this->batchId}_start_time");

            if ($endTime && $startTime) {
                $executionTime = $endTime - $startTime;
            } else {
                $executionTime = Cache::get("batch_{$this->batchId}_duration", 0);
            }
        }

        // Format the execution time nicely
        if ($executionTime > 60) {
            $minutes = floor($executionTime / 60);
            $seconds = $executionTime % 60;
            $timeFormatted = "{$minutes} menit " . number_format($seconds, 2) . " detik";
        } else {
            $timeFormatted = number_format($executionTime, 2) . " detik";
        }

        $this->logRaw("Waktu Eksekusi: {$timeFormatted}");
        $this->logRaw("---------------------- End Of Sinkronisasi data {$this->title} ----------------------");
    }

    protected function logRaw(string $message): void
    {
        $state = $this->getState();
        $state['logs'][] = $message;
        $this->setState($state);

        Log::channel('igracias')->info($message);
    }

    public function get(): array
    {
        return $this->getState()['logs'] ?? [];
    }

    public function reset(): void
    {
        // Reset all state in a single operation
        Cache::forget($this->cacheKey . '_state');

        // Initialize with default values including syncTypes array
        $this->setState([
            'hasStarted' => false,
            'hasError' => false,
            'totalData' => 0,
            'successCount' => 0,
            'errorCount' => 0,
            'errorPages' => [],
            'lastPageNum' => 0,
            'currentPage' => 0,
            'logs' => [],
            // Batch related metrics
            'batchSuccess' => 0,
            'batchFailed' => 0,
            'batchTotal' => 0,
            'batchPaginateTotal' => 0,
            // Timing information
            'executionTime' => 0,
            // Track metrics by sync type
            'syncTypes' => []
        ]);
    }

    public function setExecutionTime(float $duration): void
    {
        $state = $this->getState();
        $state['executionTime'] = $duration;
        $this->setState($state);
    }

    public function getBatchId(): string
    {
        return $this->batchId;
    }
}
