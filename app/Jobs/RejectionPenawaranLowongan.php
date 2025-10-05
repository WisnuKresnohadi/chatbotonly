<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\PendaftaranMagang;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\PendaftaranMagangStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RejectionPenawaranLowongan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $valid_step;
    private $resigned_step;
    /**
     * Create a new job instance.
     */
    public function __construct(public mixed $pendaftaran = null)
    {
        $this->valid_step = [
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 3,
        ];

        $this->resigned_step = [
            PendaftaranMagangStatusEnum::PENDING,
            PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
            PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI,
            PendaftaranMagangStatusEnum::APPROVED_BY_LKM,
            PendaftaranMagangStatusEnum::SELEKSI_TAHAP_1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3,
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pendaftaran = PendaftaranMagang::join('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->where('nim', auth()->user()->mahasiswa->nim)
        ->where('id_pendaftaran', '!=', $this->pendaftaran)
        ->whereNotIn('current_step', [
            PendaftaranMagangStatusEnum::REJECTED_BY_DOSWAL,
            PendaftaranMagangStatusEnum::REJECTED_BY_KAPRODI,
            PendaftaranMagangStatusEnum::REJECTED_BY_LKM,
            PendaftaranMagangStatusEnum::REJECTED_SCREENING,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_1,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_2,
            PendaftaranMagangStatusEnum::REJECTED_SELEKSI_TAHAP_3,
            PendaftaranMagangStatusEnum::REJECTED_PENAWARAN,
            PendaftaranMagangStatusEnum::DIBERHENTIKAN_MAGANG
        ])->get();

        foreach ($pendaftaran as $key => $value) {
            if (isset($this->valid_step[$value->current_step]) && $this->valid_step[$value->current_step] == ($value->tahapan_seleksi + 1)) {
                $value->current_step = PendaftaranMagangStatusEnum::REJECTED_PENAWARAN;
                $value->saveHistoryApproval('By System', 'By System')->save();
            } else if (array_search($value->current_step, $this->resigned_step) !== false) {
                $value->current_step = PendaftaranMagangStatusEnum::MENGUNDURKAN_DIRI;
                $value->saveHistoryApproval('By System', 'By System')->save();
            }
        }
    }
}
