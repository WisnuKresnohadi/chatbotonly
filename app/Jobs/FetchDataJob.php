<?php

namespace App\Jobs;

use App\Sync\NilaiAkhirMhsSync;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use App\Logging\IgraciasLogger;

class FetchDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected string $synchronizerClass;
    protected int $page;
    protected array $queryParams;
    protected ?int $lastPage;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    // public $tries = 3;

    public function __construct(string $synchronizerClass, int $page, array $queryParams)
    {
        $this->synchronizerClass = $synchronizerClass;
        $this->page = $page;
        $this->queryParams = $queryParams;
        $this->lastPage = 0;
    }

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        try {
            $batch = $this->batch();
            if (!$batch) {
                $this->fail(new Exception("Batch tidak ditemukan."));
                return;
            }

            $logger = $this->getLogger($batch->id);

            $synchronizer = new $this->synchronizerClass();
            $synchronizer->setQueryParams($this->queryParams);

            if ($this->page === 1) {
                $igraciasProdiId = $this->queryParams['id_prodi'] ?? 'unknown';

                $listProdi = config('igracias.prodi', []);

                $localProdiId = 'unknown';
                foreach ($listProdi as $key => $value) {
                    if ($key === $igraciasProdiId) {
                        $localProdiId = $value;
                        break;
                    }
                }

                $prodiName = $this->getProdiNameById($localProdiId);

                logIgracias('info', "id prodi local: $localProdiId");
                logIgracias('info', "id prodi igracias: $igraciasProdiId");
                logIgracias('info', "prodi: $prodiName");
                logIgracias('info', "");
            }

            $processedCount = 0;
            try {
                $response = $synchronizer->fetchData($this->page);
                $this->lastPage = $response['paginate']['last_page'] ?? 1;

                $logger->setLastPageNum($this->lastPage);

                // For the first page, we need to properly set the total data value
                if ($this->page === 1 && isset($response['paginate']) && isset($response['paginate']['total'])) {
                    $logger->logPaginationDetail($response);
                    $state = $logger->getState();
                    $state['totalData'] = (int)$response['paginate']['total'];
                    $state['currentPage'] = $this->page; // Make sure current page is set
                    $logger->setState($state);

                    $logger->setBatchTotal((int)$response['paginate']['total']);
                } else {
                    // Update current page for non-first pages too
                    $state = $logger->getState();
                    $state['currentPage'] = $this->page;
                    $logger->setState($state);
                }

                if (isset($response['data']) && $response['data']) {
                    $processedCount = $synchronizer->processData($response['data']);

                    $logger->incrementBatchSuccess($processedCount);
                }
            } catch (Exception $e) {
                $logger->incrementBatchFailed(1);

                throw new Exception($e->getMessage());
            }

            if ($this->page === 1 && isset($response['code']) && $response['code'] >= 200 && $response['code'] < 300) {

                if (isset($response['paginate']['total'])) {
                    $logger->setBatchTotal($response['paginate']['total']);
                }
                $this->lastPage = $response['paginate']['last_page'] ?? 1;

                if ($this->lastPage > 1) {
                    $batchJobs = [];
                    for ($page = 2; $page <= $this->lastPage; $page++) {
                        $batchJobs[] = new FetchDataJob($this->synchronizerClass, $page, $this->queryParams);
                    }

                    if (!empty($batchJobs) && $this->batch()) {
                        $this->batch()->add($batchJobs);
                    }
                }

                // if ($this->synchronizerClass === 'App\Sync\MhsSync') {
                //     // sync nilai akhir mahasiswa
                //     $nilaiSync = new NilaiAkhirMhsSync($this->queryParams);
                //     $this->batch()->add(new FetchDataJob($nilaiSync::class, 1, $this->queryParams));
                // }
            } elseif ($this->page == 1) {
                throw new Exception("Failed to fetch data from Igracias API");
            }
        } catch (Exception $e) {
            $batch = $this->batch();
            $logger = $this->getLogger($batch->id);

            $logger->logException($e->getMessage(), $this->page);

            if($this->page == 1) {
                Cache::put('batch_{$batch->id}_error', ['error' => true, 'message' => $e->getMessage()]);
            }

            logIgracias('error', "Job FetchDataJob gagal di page {$this->page} " . json_encode([
                'error' => true,
                'getLine' => $e->getLine(),
                'getFile' => $e->getFile(),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
            logIgracias('info', "");

            throw $e;
        }
    }

    protected function getLogger(string $batchId): IgraciasLogger
    {
        return createIgraciasLogger($this->getSyncName(), $batchId);
    }

    public function failed()
    {
        $this->batch()->decrementPendingJobs($this->batch()->id);
        $batch = $this->batch();

        $checkErrorFirst = Cache::get('batch_{$batch->id}_error');

        $dataProgress = [
            ...$batch->toArray(),
            'total' => Cache::get("batch_{$batch->id}_total", 0),
            'success' => Cache::get("batch_{$batch->id}_success", 0),
            'failed' => Cache::get("batch_{$batch->id}_failed", 0),
            'progress_batch' => Cache::get("batch_{$batch->id}_progress_batch", 0),
            'error' => false,
            'syncName' => $this->getSyncName()
        ];

        if($checkErrorFirst['error'] == true) {
            $dataProgress['error'] = true;
            $dataProgress['message'] = $checkErrorFirst['message'];
        };

        Cache::put("batch_{$batch->id}_info", $dataProgress);

        // Clean up the prodi name cache
        if ($this->page === 1) {
            $id = $this->getLocalProdiId();
            if ($id !== 'unknown') {
                Cache::forget("prodi_name_{$id}");
            }
        }
    }

    protected function getProdiNameById($id): string
    {

        $cacheKey = "prodi_name_{$id}";


        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }


        try {

            $prodiName = \App\Models\ProgramStudi::where('id_prodi', $id)
                ->select('namaprodi', 'jenjang')
                ->first();


            if ($prodiName) {
                Cache::put($cacheKey, $prodiName->jenjang . ' ' . $prodiName->namaprodi, now()->addHour());
                return $prodiName->jenjang . ' ' . $prodiName->namaprodi;
            }
        } catch (\Exception $e) {

            logIgracias('error', "Failed to get program study name: " . $e->getMessage());
        }


        $defaultName = "Program Studi ID: $id";
        Cache::put($cacheKey, $defaultName, now()->addMinutes(30));
        return $defaultName;
    }

    protected function getLocalProdiId(): string
    {
        $igraciasProdiId = $this->queryParams['id_prodi'] ?? 'unknown';
        $listProdi = config('igracias.prodi', []);

        foreach ($listProdi as $key => $value) {
            if ($key === $igraciasProdiId) {
                return $key;
            }
        }

        return 'unknown';
    }

    public function getSyncName()
    {
        $syncName = '';
        switch ($this->synchronizerClass) {
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
}
