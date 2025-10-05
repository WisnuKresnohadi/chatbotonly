<?php

namespace App\Sync;

use App\Models\Dosen;
use App\Sync\BaseSynchronize;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;

class DosenSync extends BaseSynchronize
{
    public function __construct(array $queryParams = [])
    {
        parent::__construct(env("PATHNAME_DOSEN_IGRACIAS"), $queryParams);
    }

    public function processData($dataDosen)
    {
        $configKey = 'igracias.prodi';
        $listProdi = config($configKey, []);
        $processedCount = 0;
        $failedCount = 0;

        try {
            DB::beginTransaction();

            $dataDosen = collect($dataDosen)->whereNotNull('id_prodi')->unique('nip')->toArray();
            $totalToProcess = count($dataDosen);

            foreach ($dataDosen as $dosen) {
                try {
                    $dosen['updated_at'] = Carbon::parse($dosen['updated_at'])->format('Y-m-d H:i:s');
                    Dosen::updateOrCreate(
                        ['nip' => $dosen['nip']],
                        [
                            'nip' => $dosen['nip'],
                            'kode_dosen' => $dosen['kode_dosen'],
                            'id_prodi' => $listProdi[$dosen['id_prodi']] ?? null,
                            'namadosen' => $dosen['namadosen'],
                            'nohpdosen' => $dosen['nohpdosen'],
                            'emaildosen' => $dosen['emaildosen'],
                            'status_dosen' => $dosen['status_dosen'],
                            'updated_at' => $dosen['updated_at'],
                            ...$this->getAdditionalData()
                        ]
                    );
                    $processedCount++;
                } catch (Exception $e) {
                    // Log individual failures but continue processing
                    logIgracias('error', "Gagal memproses data dosen dengan NIP: {$dosen['nip']} - {$e->getMessage()}");
                    $failedCount++;
                }
            }

            // Track success and failure using the logger's state-based methods
            $logger = $this->getLogger();
            $logger->incrementSuccessCount($processedCount);
            if ($failedCount > 0) {
                $logger->incrementErrorCount($failedCount);
            }

            DB::commit();

            return $processedCount;
        } catch (QueryException $e) {
            DB::rollBack();

            $errorCode = $e->errorInfo[1];
            if ($e->errorInfo[0] == '23000' && $errorCode == 1452) {
                $this->getLogger()->logException("Program studi terkait belum tersedia. Silakan melakukan sinkronisasi data pada program studi.");
                throw new Exception("Program studi terkait belum tersedia. Silakan melakukan sinkronisasi data pada program studi.");
            } else {
                $this->getLogger()->logException($e->getMessage());
                throw new Exception($e->getMessage());
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->getLogger()->logException($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    protected function afterSync()
    {
        logIgracias('info', 'Sinkronisasi dosen telah selesai.');
    }

    public function setQueryParams(array $params)
    {
        $this->queryParams = $params;
    }
}
