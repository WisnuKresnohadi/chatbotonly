<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\PendaftaranMagangStatusEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;

class RejectionPendaftaranTimeOut implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $valid_step;
    /**
     * Create a new job instance.
     */
    public function __construct(public mixed $lowongan = null)
    {
        $this->valid_step = [
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1 => 1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2 => 2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3 => 3,
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Cache::forget('pengajuan_magang_count');
        Cache::forget('informasi_lowongan_count');

        $pendaftaran = PendaftaranMagang::select(
            'pendaftaran_magang.id_pendaftaran', 'pendaftaran_magang.history_approval', 
            'pendaftaran_magang.current_step', 'lowongan_magang.date_confirm_closing',
            'pendaftaran_magang.id_lowongan', 'lowongan_magang.tahapan_seleksi'
        )
        ->leftJoin('lowongan_magang', 'lowongan_magang.id_lowongan', '=', 'pendaftaran_magang.id_lowongan')
        ->whereIn('pendaftaran_magang.id_lowongan', is_array($this->lowongan) ? $this->lowongan : [$this->lowongan]);

        $user = auth()->user();
        if ($user?->hasRole('Mahasiswa')) {
            $mahasiswa = $user->mahasiswa;
            $pendaftaran = $pendaftaran->where('pendaftaran_magang.nim', $mahasiswa->nim);
        }

        $pendaftaran = $pendaftaran->join(DB::raw('JSON_TABLE(pendaftaran_magang.history_approval, \'$[*]\' 
            COLUMNS (
                time DATETIME PATH \'$.time\', 
                status VARCHAR(255) PATH \'$.status\'
            )
        ) as temp'), function($join) {})
        ->whereIn('pendaftaran_magang.current_step', [
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_1,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_2,
            PendaftaranMagangStatusEnum::APPROVED_SELEKSI_TAHAP_3
        ])
        ->groupBy(
            'pendaftaran_magang.id_pendaftaran', 'pendaftaran_magang.history_approval', 
            'pendaftaran_magang.current_step', 'lowongan_magang.date_confirm_closing',
            'pendaftaran_magang.id_lowongan', 'lowongan_magang.tahapan_seleksi'
        )
        ->havingRaw("MAX(temp.time) + INTERVAL lowongan_magang.date_confirm_closing DAY < ?", [Carbon::now()])
        ->get();

        foreach ($pendaftaran as $key => $value) {
            if (isset($this->valid_step[$value->current_step]) && $this->valid_step[$value->current_step] == ($value->tahapan_seleksi + 1)) {
                $value->current_step = PendaftaranMagangStatusEnum::REJECTED_PENAWARAN;
                $value->saveHistoryApproval('By System', 'By System')->save();
                Cache::forget('informasi_lowongan_count.' . $value->id_lowongan);
            }
        }
    }
}
