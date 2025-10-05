<?php

namespace App\Sync;

use App\Models\NilaiAkhirMhs;
use App\Sync\BaseSynchronize;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;

class NilaiAkhirMhsSync extends BaseSynchronize
{
    public function __construct(array $queryParams = [])
    {
        parent::__construct(env("PATHNAME_NILAI_AKHIR_MK_IGRACIAS"), $queryParams);
    }

    public function processData($dataNilai)
    {
        $processedCount = 0;
        $failedCount = 0;

        try {
            DB::beginTransaction();

            foreach ($dataNilai as $nilaiMhs) {
                try {
                    $idMk = $nilaiMhs['nim'] . '-' . $nilaiMhs['id_mk'];
                    $nilaiMhs['nilai_mk'] = floatval($nilaiMhs['nilai_mk']) ?? 0;
                    $nilaiMhs['created_at'] = Carbon::parse($nilaiMhs['startdate'])->format('Y-m-d H:i:s');

                    NilaiAkhirMhs::updateOrCreate(
                        ['id_nilai_akhir_mhs' => $idMk],
                        [
                            'id_mk' => $nilaiMhs['id_mk'],
                            'nim' => $nilaiMhs['nim'],
                            'semester' => $nilaiMhs['semester'],
                            'predikat' => $nilaiMhs['predikat'],
                            'nilai_mk' => $nilaiMhs['nilai_mk'],
                            'created_at' => $nilaiMhs['created_at']
                        ]
                    );
                    $processedCount++;
                } catch(QueryException $e) {
                    $errorMessage = $e->errorInfo[2];

                    if (str_contains($errorMessage, 'nilai_akhir_mhs_nim_foreign')) {
                        logIgracias('error', "NIM mahasiswa tidak ditemukan untuk nilai: {$nilaiMhs['nim']} - {$nilaiMhs['id_mk']}");
                        $failedCount++;
                        continue;
                    } elseif (str_contains($errorMessage, 'nilai_akhir_mhs_id_mk_foreign')) {
                        logIgracias('error', "ID MK tidak ditemukan untuk nilai: {$nilaiMhs['nim']} - {$nilaiMhs['id_mk']}");
                        $failedCount++;
                        continue;
                    } else {
                        throw new Exception($e->getMessage());
                    }
                }
            }

            // Track success and failure using the logger's state-based methods
            $logger = $this->getLogger();
            $logger->incrementSuccessCount($processedCount);
            if ($failedCount > 0) {
                $logger->incrementErrorCount($failedCount);
            }

            DB::commit();
            logIgracias('info', "Sinkronisasi nilai akhir berhasil: {$processedCount} data berhasil, {$failedCount} data gagal");

            return $processedCount;
        } catch (QueryException $e) {
            DB::rollBack();
            $errorMessage = $e->getMessage();

            $errorCode = $e->errorInfo[1] ?? 0;
            if ($e->errorInfo[0] == '23000' && $errorCode == 1452) {
                $this->getLogger()->logException("Matakuliah atau mahasiswa terkait belum tersedia. Silakan melakukan sinkronisasi data pada matakuliah atau mahasiswa terlebih dahulu.");
                throw new Exception("Matakuliah atau mahasiswa terkait belum tersedia. Silakan melakukan sinkronisasi data pada matakuliah atau mahasiswa terlebih dahulu.");
            } else {
                $this->getLogger()->logException($errorMessage);
                throw new Exception($errorMessage);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $this->getLogger()->logException($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    protected function afterSync()
    {
        logIgracias('info', 'Sinkronisasi nilai akhir telah selesai.');
    }

    public function setQueryParams(array $params)
    {
        $this->queryParams = $params;
    }
}
