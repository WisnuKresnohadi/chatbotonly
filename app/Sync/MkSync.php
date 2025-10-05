<?php

namespace App\Sync;

use App\Models\MataKuliah;
use App\Sync\BaseSynchronize;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\QueryException;

class MkSync extends BaseSynchronize
{
    public function __construct(array $queryParams = [])
    {
        parent::__construct(env("PATHNAME_MK_IGRACIAS"), $queryParams);
    }

    public function processData($dataMk)
    {
        $configKey = 'igracias.prodi';
        $listProdi = config($configKey, []);
        $processedCount = 0;
        $failedCount = 0;

        try {
            DB::beginTransaction();

            foreach ($dataMk as $mk) {
                try {
                    $mk['updated_at'] = Carbon::parse($mk['updated_at'])->format('Y-m-d H:i:s');

                    MataKuliah::updateOrCreate(
                        ['id_mk' => $mk["id_mk"]],
                        [
                            'id_mk' => $mk['id_mk'],
                            'kode_mk' => $mk['kode_mk'],
                            'id_prodi' => $listProdi[$mk['id_prodi']] ?? null,
                            'namamk' => $mk['namamk'],
                            'sks' => $mk['sks'],
                            'kurikulum' => $mk['curriculumyear'],
                            'updated_at' => $mk['updated_at'],
                            ...$this->getAdditionalData()
                        ]
                    );
                    $processedCount++;
                } catch (Exception $e) {
                    // Log individual failures but continue processing
                    logIgracias('error', "Gagal memproses matakuliah dengan ID: {$mk['id_mk']} - {$e->getMessage()}");
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
            logIgracias('info', "Sinkronisasi matakuliah berhasil: {$processedCount} data berhasil, {$failedCount} data gagal");

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
        logIgracias('info', 'Sinkronisasi matakuliah telah selesai.');
    }

    public function setQueryParams(array $params)
    {
        $this->queryParams = $params;
    }
}
