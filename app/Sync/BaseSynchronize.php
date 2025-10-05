<?php

namespace App\Sync;

use App\Http\Controllers\Auth\LoginController;
use App\Jobs\FetchDataJob;
use App\Logging\IgraciasLogger;
use App\Models\Fakultas;
use App\Models\Universitas;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Bus\Batch;
use Illuminate\Bus\BatchRepository;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseSynchronize
{
    protected string $baseUrl;
    protected string $authTokenKey;
    protected int $maxRetries = 3;
    public array $queryParams = [
        'limit' => 500,
        'page' => 1
    ];
    protected array $additionalData = [];
    protected ?IgraciasLogger $logger = null;

    public function __construct(string $endpoint, array $queryParams = [])
    {
        $this->baseUrl = env('BASE_URL_IGRACIAS') . '/' . $endpoint;
        $this->authTokenKey = env('AUTH_TOKEN_KEY_IGRACIAS', 'auth_token_igracias');
        $this->additionalData = [
            "id_univ" => Universitas::where('namauniv', "Telkom University")->pluck("id_univ")->first(),
            "id_fakultas" => Fakultas::where('namafakultas', "Fakultas Ilmu Terapan")->pluck("id_fakultas")->first()
        ];
        $this->queryParams = $queryParams;
    }

    // Autentikasi token dengan pengecekan cache
    public function authenticate()
    {
        if (Cache::has($this->authTokenKey)) {
            return decrypt(Cache::get($this->authTokenKey));
        }

        return $this->login();
    }

    // Login untuk mengambil token baru jika tidak ada token yang valid
    protected function login()
    {
        try {
            $token = app(LoginController::class)->loginIgracias();

            if (!Cache::has($this->authTokenKey)) {
                logIgracias('info', 'Storing token in cache explicitly');
                Cache::put($this->authTokenKey, encrypt($token), now()->addDay());
            }

            return $token;
        } catch (Exception $e) {

            $batchId = $this->getLogger()->getBatchId();
            Cache::put("batch_{$batchId}_error", [
                'error' => true,
                'message' => "Kredensial Anda tidak valid atau token telah kedaluwarsa. Silakan hubungi administrator jika masalah ini terus berlanjut."
            ], now()->addHours(1));

            throw new Exception("Kredensial Anda tidak valid atau token telah kedaluwarsa. Silakan hubungi administrator jika masalah ini terus berlanjut.");
        }
    }

    // Fetch data dengan mekanisme retry
    public function fetchData(int $page = 1, int $retry = 1)
    {
        try {
            $authToken = $this->authenticate();
            $this->queryParams['page'] = $page;
            $response = Http::withToken($authToken)->get($this->baseUrl, $this->queryParams);

            if (($response->status() === 401 || $response->status() === 500) && $retry < $this->maxRetries) {
                Cache::forget($this->authTokenKey); // Force re-authentication on next try

                // Log the retry attempt with the correct error
                $errorMessage = "Kredensial Anda tidak valid atau token telah kedaluwarsa. Silakan hubungi administrator jika masalah ini terus berlanjut.";
                $this->getLogger()->logRetry($page, $retry + 1, $this->getSyncName(), [
                    'error' => true,
                    'code' => $response->status(),
                    'message' => $errorMessage
                ]);

                return $this->fetchData($page, $retry + 1);
            }

            if ($response->successful()) {
                $result = $response->json();

                // Store last page info for calculating averages
                if ($page === 1 && isset($result['paginate']) && isset($result['paginate']['last_page'])) {
                    $userId = auth()->id() ?? 'system';
                    $batchId = Cache::get("sync_batch_active_id_$userId") ?? '';
                    if ($batchId) {
                        Cache::put("batch_{$batchId}_paginate_last_page", $result['paginate']['last_page']);
                    }
                }

                if ($page === 1) {
                    $result['error'] = false;
                }

                // Log successful page fetch
                $this->getLogger()->logPage($page, $this->getSyncName(), $result);

                return $result;
            }

            // Handle unsuccessful response
            $error = [
                'error' => true,
                'code' => $response->status(),
                'message' => $response->json()['message'] ?? 'Unknown error'
            ];

            $this->getLogger()->logRetry($page, $retry + 1, $this->getSyncName(), $error);
            throw new Exception($error['message']);
        } catch (ConnectionException $e) {
            // Tidak bisa konek sama sekali (offline, DNS, timeout)
            throw new Exception("Tidak dapat terhubung ke server Igracias. Periksa koneksi Anda atau coba beberapa saat lagi.");
        } catch (RequestException $e) {
            throw new Exception("Permintaan ke server Igracias gagal: " . $e->getMessage());
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            if ($retry < $this->maxRetries) {

                $this->getLogger()->logRetry($page, $retry + 1, $this->getSyncName(), [
                    'error' => true,
                    'code' => 500,
                    'message' => $errorMessage
                ]);

                return $this->fetchData($page, $retry + 1);
            }

            $batchId = $this->getLogger()->getBatchId();
            Cache::put("batch_{$batchId}_error", [
                'error' => true,
                'message' => $errorMessage
            ], now()->addHours(1));

            $this->getLogger()->logException($errorMessage, $page);
            throw new Exception($errorMessage);
        }
    }

    protected function getLogger(): IgraciasLogger
    {
        if (!$this->logger) {
            $userId = auth()->id() ?? 'system';
            $batchId = Cache::get("sync_batch_active_id_$userId") ?? '';
            $this->logger = createIgraciasLogger($this->getSyncName(), $batchId);
        }
        return $this->logger;
    }

    // Fungsi sinkronisasi utama (hanya jalankan job pertama)
    public function synchronize()
    {
        DB::beginTransaction();
        try {
            $userId = auth()->user()->id;
            $existingBatchId = Cache::get("sync_batch_active_id_$userId");
            
            // Start time tracking
            $startTime = microtime(true);
            Cache::put("sync_batch_active_start_time_$userId", $startTime, now()->addHours(2));

            if ($existingBatchId) {
                // Find the existing batch
                $batch = Bus::findBatch($existingBatchId);

                if ($batch && !$batch->cancelled() && !$batch->finished()) {
                    // Add new job to the existing batch
                    $job = new FetchDataJob(static::class, 1, $this->queryParams);
                    $batch->add([$job]);

                    Log::info("Menambahkan job baru ke batch yang sedang berjalan: {$existingBatchId}");
                    DB::commit();
                    return;
                } else {
                    // Remove the old batch ID if it's finished or cancelled
                    Cache::forget("sync_batch_active_id_$userId");
                    Cache::forget("sync_batch_active_start_time_$userId");
                }
            }

            $listProdi = config('igracias.prodi', []);

            $localProdiId = 'unknown';
            foreach ($listProdi as $key => $value) {
                if (isset($this->queryParams['id_prodi']) && $key === $this->queryParams['id_prodi']) {
                    $localProdiId = $value;
                    break;
                }
            }

            // If no active batch, create a new one
            $batchJobs = [new FetchDataJob(static::class, 1, $this->queryParams)];
            $batch = Bus::batch($batchJobs)
                ->name('Sync Data Batch')
                ->onQueue('igracias')
                ->before(function (Batch $batch) use($localProdiId, $startTime, $userId) {
                    Cache::forget("batch_{$batch->id}_total");
                    Cache::forget("batch_{$batch->id}_success");
                    Cache::forget("batch_{$batch->id}_failed");
                    Cache::forget("batch_{$batch->id}_error"); // Also clear any existing error state
                    Cache::put("batch_{$batch->id}_isRead", 0);
                    
                    // Store start time in batch-specific cache too
                    Cache::put("batch_{$batch->id}_start_time", $startTime, now()->addHours(2));

                    // Initialize logger with batch ID
                    $logger = createIgraciasLogger($this->getSyncName(), $batch->id);
                    $logger->start();

                    Cache::put("batch_{$batch->id}_info", [
                        ...$batch->toArray(),
                        'prodi' => $this->getProdiNameById($localProdiId) ?? null,
                        'progress_batch' => Cache::get("batch_{$batch->id}_progress_batch", 0),
                        'error' => false,
                        'syncName' => $this->getSyncName(),
                        'startTime' => $startTime
                    ]);
                })
                ->progress(function (Batch $batch) use ($localProdiId) {
                    // Get current error status
                    $errorInfo = Cache::get("batch_{$batch->id}_error", ['error' => false]);

                    Cache::put("batch_{$batch->id}_info", [
                        ...$batch->toArray(),
                        'prodi' => $this->getProdiNameById($localProdiId) ?? null,
                        'progress_batch' => Cache::get("batch_{$batch->id}_progress_batch", 0),
                        'error' => $errorInfo['error'], // Use the current error status
                        'message' => $errorInfo['error'] ? ($errorInfo['message'] ?? 'An error occurred') : null,
                        'syncName' => $this->getSyncName()
                    ]);
                })
                ->catch(function (Batch $batch, Throwable $e) {
                    $logger = createIgraciasLogger($this->getSyncName(), $batch->id);
                    $logger->logException($e->getMessage());

                    // Set error state in cache
                    Cache::put("batch_{$batch->id}_error", [
                        'error' => true,
                        'message' => $e->getMessage()
                    ], now()->addHours(1));

                    // Update batch info
                    $batchInfo = Cache::get("batch_{$batch->id}_info", []);
                    $batchInfo['error'] = true;
                    $batchInfo['message'] = $e->getMessage();
                    Cache::put("batch_{$batch->id}_info", $batchInfo, now()->addHours(1));
                })
                ->then(function (Batch $batch) use($localProdiId) {
                    // Get current error status
                    $errorInfo = Cache::get("batch_{$batch->id}_error", ['error' => false]);

                    Cache::put("batch_{$batch->id}_info", [
                        ...$batch->toArray(),
                        'prodi' => $this->getProdiNameById($localProdiId) ?? null,
                        'progress_batch' => Cache::get("batch_{$batch->id}_progress_batch", 0),
                        'error' => $errorInfo['error'], // Use the error status from cache
                        'message' => $errorInfo['error'] ? ($errorInfo['message'] ?? 'An error occurred') : null,
                        'syncName' => $this->getSyncName()
                    ]);
                })
                ->finally(function (Batch $batch) use ($userId) {
                    if (!$batch->finished()) {
                        resolve(BatchRepository::class)->markAsFinished($batch->id);
                    }
                    
                    // Get end time and calculate duration
                    $endTime = microtime(true);
                    $startTime = Cache::get("batch_{$batch->id}_start_time", $endTime);
                    $duration = $endTime - $startTime;
                    
                    // Store end time and duration
                    Cache::put("batch_{$batch->id}_end_time", $endTime, now()->addHours(2));
                    Cache::put("batch_{$batch->id}_duration", $duration, now()->addHours(2));
                    Cache::put("sync_batch_active_end_time_$userId", $endTime, now()->addHours(2));

                    $logger = createIgraciasLogger($this->getSyncName(), $batch->id);
                    $logger->setExecutionTime($duration);
                    $logger->end();

                    // Artisan::call('queue:prune-batches --hours=0');
                })
                ->allowFailures()
                ->dispatch();

            Cache::put("sync_batch_active_id_$userId", $batch->id);

            DB::commit();
            Log::info("Batch job untuk sinkronisasi data telah dimulai.");
        } catch (Exception $e) {
            DB::rollBack();
            
            // Clean up time tracking on error
            $userId = auth()->user()->id;
            Cache::forget("sync_batch_active_start_time_$userId");
            
            Log::error("Sync gagal: " . $e->getMessage());
            throw new Exception("Sync gagal: " . $e->getMessage());
        }
    }

    protected function getProdiNameById($id): string
    {
        // Generate a cache key specific to this prodi ID
        $cacheKey = "prodi_name_{$id}";

        // Check if we already have this prodi name cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // If not in cache, try to fetch it from the database
        try {
            // Try to get the program study name from database
            $prodiName = \App\Models\ProgramStudi::where('id_prodi', $id)
                ->select('namaprodi', 'jenjang')
                ->first();

            // If found in database, cache it for future use
            if ($prodiName) {
                Cache::put($cacheKey, $prodiName->jenjang . ' ' . $prodiName->namaprodi, now()->addHour());
                return $prodiName->jenjang . ' ' . $prodiName->namaprodi;
            }
        } catch (\Exception $e) {
            // If there's any error, fallback to the default value
            logIgracias('error', "Failed to get program study name: " . $e->getMessage());
        }

        // Default fallback value
        $defaultName = "Program Studi ID: $id";
        Cache::put($cacheKey, $defaultName, now()->addMinutes(30));
        return $defaultName;
    }

    public function getSyncName()
    {
        $syncName = '';
        switch (static::class) {
            case 'App\Sync\DosenSync':
                $syncName = 'Dosen';
                break;
            case 'App\Sync\MhsSync':
                $syncName = 'Mahasiswa';
                break;
            case 'App\Sync\MkSync':
                $syncName = 'Mata Kuliah';
                break;
            case 'App\Sync\NilaiAkhirMhsSync':
                $syncName = 'Nilai Akhir Mahasiswa';
                break;
            case 'App\Sync\ProdiSync':
                $syncName = 'Program Studi';
                break;
        }
        return $syncName;
    }

    public function getAdditionalData()
    {
        return $this->additionalData;
    }

    public function setQueryParams(array $params)
    {
        $this->queryParams = $params;
    }

    abstract public function processData($data);
}
