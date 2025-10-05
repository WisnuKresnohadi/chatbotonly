<?php

namespace App\Jobs;

use App\Models\ExperiencePendaftaran;
use App\Models\PendaftaranMagang;
use App\Models\SertifikatPendaftaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CloneDataPendaftaran implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public int $maxTries = 5;

    protected string $id_pendaftaran;
    protected array $informasi_pribadi;
    protected array $experience;
    protected array $sertifikat;
    /**
     * Create a new job instance.
     */
    public function __construct(string $id_pendaftaran, array $informasi_pribadi, array $experience, array $sertifikat)
    {
        $this->id_pendaftaran = $id_pendaftaran;
        $this->informasi_pribadi = $informasi_pribadi;
        $this->experience = $experience;
        $this->sertifikat = $sertifikat;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();
        try {
            $nim = $this->experience[0]['nim'];
            // first clone informasi pribadi using array $informasi_pribadi
            $pendaftaran = PendaftaranMagang::where('id_pendaftaran', $this->id_pendaftaran)->update($this->informasi_pribadi);
            // second clone experience using array $experience to $experience_pendaftaran
            array_walk($this->experience, function (&$item) {
                $item['id_pendaftaran'] = $this->id_pendaftaran;
            });
            ExperiencePendaftaran::insert($this->experience);
            // third clone sertifikat using array $sertifikat to $sertifikat_pendaftaran
            $sertifikat_pendaftaran = [];
            foreach ($this->sertifikat as $key => $value) {
                // nama file with format file
                $namaFile = str_replace(' ', '_', strtolower($value['nama_sertif'])) . pathinfo($value['file_sertif'], PATHINFO_EXTENSION);
                $file = null;
                if (Storage::exists($value['file_sertif'])) {
                    if(Storage::exists('sertifikat/pendaftaran/' . $nim . '/' . $namaFile)) {
                        Storage::delete('sertifikat/pendaftaran/' . $nim . '/' . $namaFile);
                    };
                    $file = Storage::copy($value['file_sertif'], 'sertifikat/pendaftaran/' . $nim . '/' . $namaFile);
                }

                $value['file_sertif'] = $file;
                $value['id_pendaftaran'] = $this->id_pendaftaran;
                $sertifikat_pendaftaran[] = $value;
            }
            SertifikatPendaftaran::insert($sertifikat_pendaftaran);
            DB::commit();
            Log::info('Clone data pendaftaran success');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Clone data pendaftaran failed', ['message' => $e->getMessage()]);
            $this->fail($e);
        }
    }
}
