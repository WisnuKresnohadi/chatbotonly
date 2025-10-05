<?php

namespace App\Sync;

use App\Models\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;

class MhsSync extends BaseSynchronize
{
    public function __construct(array $queryParams = [])
    {
        parent::__construct(env("PATHNAME_MHS_IGRACIAS"), $queryParams);
    }

    public function processData($dataMahasiswa)
    {
        $logger = $this->getLogger();
        $processedCount = 0;
        $failedCount = 0;

        try {
            DB::beginTransaction();

            $dataMahasiswaGroupByNim = collect($dataMahasiswa)->groupBy('nim');
            $configKey = 'igracias.prodi';
            $listProdi = config($configKey, []);

            foreach ($dataMahasiswaGroupByNim as $listMhs) {
                try {
                    $listMhs = $listMhs->sortByDesc('test_bahasa');
                    $mhs = $listMhs->first();

                    // if (count($listMhs) > 1) {
                    //     $mhs = $listMhs->where("test_type", 'EPRT')->where('status', "SUDAH LULUS")->first() ??
                    //         $listMhs->where("test_type",'!=', 'EPRT')->where('status', "SUDAH LULUS")->first() ??
                    //         $listMhs->last();
                    // }

                    $mhs['tesbahasa'] = floatval($mhs['test_bahasa']) ?? 0;
                    $mhs['tipetesbahasa'] = $mhs['test_type'];
                    $mhs['ipk'] = floatval($mhs['ipk']) ?? 0;
                    $mhs['tak'] = floatval($mhs['tak']) ?? 0;
                    $mhs['tunggakan_bpp'] = $mhs['tunggakan_bpk'] > 0 ? "Iya" : "Tidak";
                    $mhs['created_at'] = Carbon::parse($mhs['startdate'])->format('Y-m-d H:i:s');
                    unset($mhs['status']);

                    try {
                        Mahasiswa::updateOrCreate(
                            ['nim' => $mhs["nim"]],
                            [
                                'nim' => $mhs['nim'],
                                'angkatan' => $mhs['angkatan'],
                                'id_prodi' => $listProdi[$mhs['id_prodi']] ?? null,
                                'namamhs' => $mhs['namamhs'],
                                'alamatmhs' => $mhs['alamatmhs'],
                                'emailmhs' => $mhs['emailmhs'],
                                'nohpmhs' => $mhs['nohpmhs'],
                                'tesbahasa' => $mhs['tesbahasa'],
                                'tipetesbahasa' => $mhs['tipetesbahasa'],
                                'ipk' => $mhs['ipk'],
                                'tak' => $mhs['tak'],
                                'tunggakan_bpp' => $mhs['tunggakan_bpp'],
                                'kode_dosen' => $mhs['kode_dosen'],
                                'kelas' => $mhs['kelas'],
                                'created_at' => $mhs['created_at'],
                                ...$this->getAdditionalData()
                            ]
                        );
                        $processedCount++;
                    } catch(QueryException $e) {
                        $errorMessage = $e->errorInfo[2];

                        if (str_contains($errorMessage, 'mahasiswa_id_prodi_foreign')) {
                            $failedCount++;
                            logIgracias('error', "Program studi untuk mahasiswa {$mhs['nim']} tidak ditemukan");
                            $logger->logException("Program studi untuk mahasiswa {$mhs['nim']} tidak ditemukan");
                            continue;
                        } elseif (str_contains($errorMessage, 'mahasiswa_kode_dosen_foreign')) {
                            // Try again without dosen reference
                            $mhs['kode_dosen'] = null;
                            Mahasiswa::updateOrCreate(
                                ['nim' => $mhs["nim"]],
                                [
                                    'nim' => $mhs['nim'],
                                    'angkatan' => $mhs['angkatan'],
                                    'id_prodi' => $listProdi[$mhs['id_prodi']] ?? null,
                                    'namamhs' => $mhs['namamhs'],
                                    'alamatmhs' => $mhs['alamatmhs'],
                                    'emailmhs' => $mhs['emailmhs'],
                                    'nohpmhs' => $mhs['nohpmhs'],
                                    'tesbahasa' => $mhs['tesbahasa'],
                                    'tipetesbahasa' => $mhs['tipetesbahasa'],
                                    'ipk' => $mhs['ipk'],
                                    'tak' => $mhs['tak'],
                                    'tunggakan_bpp' => $mhs['tunggakan_bpp'],
                                    'kode_dosen' => $mhs['kode_dosen'],
                                    'kelas' => $mhs['kelas'],
                                    'created_at' => $mhs['created_at'],
                                    ...$this->getAdditionalData()
                                ]
                            );
                            // $processedCount++;
                            // logIgracias('info', "Berhasil menyimpan data mahasiswa {$mhs['nim']} tanpa referensi dosen");

                            throw new Exception("Referensi dosen untuk mahasiswa {$mhs['nim']} tidak ditemukan");
                        } else {
                            throw new Exception($e->getMessage());
                        }
                    }
                } catch (Exception $e) {
                    logIgracias('error', "Gagal memproses mahasiswa: {$mhs['nim']} - {$e->getMessage()}");
                    $failedCount++;

                    // Add the error to logger's error pages so it shows in the end summary
                    $logger->logException("Gagal memproses mahasiswa: {$mhs['nim']} - {$e->getMessage()}", 0);
                }
            }

            // Ensure metrics are properly tracked
            $logger->incrementSuccessCount($processedCount);
            if ($failedCount > 0) {
                $logger->incrementErrorCount($failedCount);
            }

            // Update the totalData if it's not accurate
            $state = $logger->getState();
            if ($state['totalData'] < ($processedCount + $failedCount)) {
                $state['totalData'] = $processedCount + $failedCount;
                $logger->setState($state);
                $logger->setBatchTotal($processedCount + $failedCount);
            }

            DB::commit();
            logIgracias('info', "Sinkronisasi mahasiswa berhasil: {$processedCount} data berhasil, {$failedCount} data gagal");

            return $processedCount;
        } catch (Exception $e) {
            DB::rollBack();
            $this->getLogger()->logException($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    protected function afterSync()
    {
        logIgracias('info', 'Sinkronisasi mahasiswa telah selesai.');
    }

    public function setQueryParams(array $params)
    {
        $this->queryParams = $params;
    }
}
