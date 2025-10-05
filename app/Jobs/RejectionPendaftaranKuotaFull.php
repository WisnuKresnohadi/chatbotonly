<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\LowonganMagang;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\PendaftaranMagangStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RejectionPendaftaranKuotaFull implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $valid_step;
    private $rejected_step;
    /**
     * Create a new job instance.
     */
    public function __construct(public mixed $lowongan = null)
    {
        $this->valid_step = [
            PendaftaranMagangStatusEnum::PENDING,
            PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
            PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI,
            PendaftaranMagangStatusEnum::APPROVED_BY_LKM,
            PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1
        ];

        $this->rejected_step = [
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Cache::forget('pengajuan_magang_count');

        $lowonganMagang = LowonganMagang::whereIn('id_lowongan', is_array($this->lowongan) ? $this->lowongan : [$this->lowongan])->get();
        $pendaftaran = PendaftaranMagang::whereIn('id_lowongan', $lowonganMagang->pluck('id_lowongan')->toArray());

        $user = auth()->user();
        if ($user?->hasRole('Mahasiswa')) $pendaftaran = $pendaftaran->clone()->where('nim', $user->mahasiswa->nim);

        $pendaftaran = $pendaftaran->get();

        $arrayPendaftar = [];
        foreach ($lowonganMagang as $key => $value) {
            $kuota_full = $pendaftaran->where('id_lowongan', $value->id_lowongan)->where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)->count() == $value->kuota;

            if (!$kuota_full) continue;

            $pick = $pendaftaran
            ->where('id_lowongan', $value->id_lowongan)
            ->whereIn('current_step', [
                PendaftaranMagangStatusEnum::PENDING,
                PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
                PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI,
                PendaftaranMagangStatusEnum::APPROVED_BY_LKM,
                PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2,
                PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3
            ]);

            foreach ($pick as $k => $v) {
                $arrayPendaftar[] = $v;    
            }
        }
        
        foreach ($arrayPendaftar as $key => $value) {
            if (array_search($value->current_step, $this->valid_step) !== false) {
                $value->current_step = PendaftaranMagangStatusEnum::REJECTED_SCREENING;
                $value->saveHistoryApproval('By System', 'By System')->save();
                Cache::forget('informasi_lowongan_count.' . $value->id_lowongan);
            } else if (isset($this->rejected_step[$value->current_step])) {
                $value->current_step = $this->rejected_step[$value->current_step];
                $value->saveHistoryApproval('By System', 'By System')->save();
            }
        }
    }
}
