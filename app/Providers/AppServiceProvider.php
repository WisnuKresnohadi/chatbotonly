<?php

namespace App\Providers;

use App\Enums\BerkasAkhirMagangStatus;
use App\Models\Industri;
use Illuminate\View\View;
use App\Helpers\MenuHelper;
use App\Models\LowonganMagang;
use App\Models\PendaftaranMagang;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Enums\LowonganMagangStatusEnum;
use Illuminate\Support\ServiceProvider;
use App\Jobs\WriteAndReadCounterBadgeJob;
use App\Enums\PendaftaranMagangStatusEnum;
use App\Models\BerkasMagang;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Facades\URL;
use PDO;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') === 'local' && request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        ViewFacade::composer('partials.sidemenu', function (View $view) {
            $user = auth()->user();
            $dataCounter_ = [];
            $dataCounter = WriteAndReadCounterBadgeJob::getInstance();

            if ($user->hasAnyRole(['Super Admin', 'LKM'])) {
                $dataCounter_ = $dataCounter->writeAndReadCache('pengajuan_magang_count', function () {
                    return PendaftaranMagang::whereIn('current_step', [
                        PendaftaranMagangStatusEnum::PENDING,
                        PendaftaranMagangStatusEnum::APPROVED_BY_DOSWAL,
                        PendaftaranMagangStatusEnum::APPROVED_BY_KAPRODI
                    ])->count();
                })
                ->writeAndReadCache('kelola_mitra_count', function () {
                    return Industri::where('statusapprove', 0)->count();
                })
                ->writeAndReadCache('data_mahasiswa_count', function () {
                    return PendaftaranMagang::where('current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)
                    ->whereNull('dokumen_skm')->count();
                })
                ->writeAndReadCache('berkas_akhir_magang.fakultas_count', function () {
                    return PendaftaranMagang::select('pendaftaran_magang.id_pendaftaran')
                    ->join('mhs_magang', 'pendaftaran_magang.id_pendaftaran', '=', 'mhs_magang.id_pendaftaran')
                    ->join('berkas_magang', 'berkas_magang.id_jenismagang', 'mhs_magang.jenis_magang')
                    ->leftJoin('berkas_akhir_magang', function ($q) {
                        return $q->on('berkas_akhir_magang.id_berkas_magang', '=', 'berkas_magang.id_berkas_magang')
                        ->whereRaw('berkas_akhir_magang.id_mhsmagang = mhs_magang.id_mhsmagang')
                        ->where('berkas_akhir_magang.status_berkas', '=', BerkasAkhirMagangStatus::PENDING);
                    })
                    ->where('pendaftaran_magang.current_step', PendaftaranMagangStatusEnum::APPROVED_PENAWARAN)
                    ->groupBy('pendaftaran_magang.id_pendaftaran')
                    ->havingRaw('count(berkas_akhir_magang.status_berkas) > 0')
                    ->count();
                })
                ->writeAndReadCache('lowongan.kelola_count', function () {
                    return LowonganMagang::where('statusaprove', LowonganMagangStatusEnum::PENDING)->count();
                })->get();
            } else if ($user->hasAnyRole(['Mitra'])) {
                $id_industri = $user->pegawai_industri->id_industri;
                $dataCounter_ = $dataCounter->writeAndReadCache('informasi_lowongan_count.' . $id_industri, function () use ($user) {
                    return PendaftaranMagang::whereHas('lowongan_magang', function ($q) use ($user) {
                        $q->where('id_industri', $user->pegawai_industri->id_industri);
                    })->where('current_step', PendaftaranMagangStatusEnum::APPROVED_BY_LKM)->count();
                })->get();
            }

            $data['menu'] = MenuHelper::getInstance((array) $dataCounter_);
            $view->with($data);
        });
    }
}
