<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelolaMitraController;
use App\Http\Controllers\MasterEmailController;
use App\Http\Controllers\InformasiMitraController;
use App\Http\Controllers\LowonganMagangController;
use App\Http\Controllers\ProfileCompanyController;
use App\Http\Controllers\PegawaiIndustriController;
use App\Http\Controllers\AssignPembimbingController;
use App\Http\Controllers\LowonganMagangLkmController;
use App\Http\Controllers\Logbook\LogbookPemLapController;
use App\Http\Controllers\Dashboard\DashboardMitraController;

Route::prefix('kelola-mitra')->name('kelola_mitra')->controller(KelolaMitraController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/show', 'show')->name('.show');
    Route::post('/store', 'store')->name('.store');
    Route::get('/edit/{id}', 'edit')->name('.edit');
    Route::post('/update-status-kerja-sama/{id}', 'statusKerjaSama')->name('.status_kerja_sama');
    // Route::post('/update/{id}', 'update')->name('.update');
    Route::post('/status/{id}', 'status')->name('.status');
    Route::post('/approved/{id}', 'approved')->name('.approved');
    Route::post('/rejected/{id}', 'rejected')->name('.rejected');
    Route::post('delete/{id}', 'delete')->name('.delete');
    Route::post('reset-password/{id}', 'resetPassword')->name('.reset_password');
});

Route::prefix('lowongan-magang')->controller(LowonganMagangController::class)->group(function () {
    Route::prefix('informasi-lowongan')->name('informasi_lowongan')->group(function () {
        Route::get('/', 'indexInformasi')->middleware('permission:informasi_lowongan_mitra.view');
        Route::get('/show', 'showInformasi')->name('.show')->middleware('permission:informasi_lowongan_mitra.view');
        Route::post('set-date-confirm-closing/{id}', 'setDateConfirmClosing')->name('.set_confirm_closing')->middleware('permission:informasi_lowongan_mitra.set_confirm_closing');

        Route::get('/detail/{id}', 'detailInformasi')->name('.detail')->middleware('permission:informasi_lowongan_mitra.view');
        Route::get('/get-data/{id}', 'getDataDetailInformasi')->name('.get_data')->middleware('permission:informasi_lowongan_mitra.view');
        Route::post('update-status', 'updateStatusPelamar')->name('.update_status')->middleware('permission:informasi_lowongan_mitra.approval');
        Route::get('get-kandidat/{tahap}', 'getKandidat')->name('.get_kandidat')->middleware('permission:informasi_lowongan_mitra.view');
        Route::post('set-jadwal/{id}', 'setJadwal')->name('.set_jadwal')->middleware('permission:informasi_lowongan_mitra.set_jadwal');
        Route::get('show-cv/{nim}', 'showCV')->name('.show_cv');

        Route::get('detail-kandidat/{id}','detailKandidat')->name('.detail_kandidat');
        Route::get('detail-kriteria-kandidat/{id}','getDetailKriteriaKandidat')->name('.detail_kriteria_kandidat');
        Route::post('update-nilai-kriteria/{id}','updateNilaiKriteria')->name('.update_nilai_kriteria');
    });
    Route::prefix('kelola-lowongan')->name('kelola_lowongan')->group(function () {
        Route::get('/', 'index')->middleware('permission:kelola_lowongan_mitra.view');
        Route::get('/show', 'show')->name('.show')->middleware('permission:kelola_lowongan_mitra.view');
        Route::get('/create', 'create')->name('.create')->middleware('permission:kelola_lowongan_mitra.create');
        Route::post('/store', 'store')->name('.store')->middleware('permission:kelola_lowongan_mitra.create');
        Route::get('/detail/{id}', 'detail')->name('.detail')->middleware('permission:kelola_lowongan_mitra.view');
        Route::get('/edit/{id}', 'edit')->name('.edit')->middleware('permission:kelola_lowongan_mitra.update');
        Route::post('/update/{id}', 'update')->name('.update')->middleware('permission:kelola_lowongan_mitra.update');
        Route::post('/change-status/{id}', 'status')->name('.change_status')->middleware('permission:kelola_lowongan_mitra.update');
        Route::get('/get-takedown/{id}', 'getTakedown')->name('.get_takedown')->middleware('permission:kelola_lowongan_mitra.update');
        Route::post('/update-takedown/{id}', 'updateTakedown')->name('.update_takedown')->middleware('permission:kelola_lowongan_mitra.update');

        // Pembobotan Kriteria
        Route::prefix('pengaturan-kriteria')->name('.pengaturan_kriteria')->group(function(){
            Route::get('/{id}','pembobotanLowongan')->name('.show');
            Route::post('/store/{id}','updatePembobotan')->name('.store');
        });
    });
});

Route::prefix('lowongan')->name('lowongan')->group(function () {
    Route::prefix('informasi')->name('.informasi')->middleware('permission:informasi_lowongan_lkm.view')->controller(InformasiMitraController::class)->group(function () {
        Route::get('/', 'listMitra');
        Route::get('get-mitra', 'getListMitra')->name('.get_mitra');

        Route::get('mitra/{id}', 'index')->name('.list_lowongan');
        Route::get('show/{id}', 'show')->name('.show');

        Route::get('detail/{id}', 'detail')->name('.detail');
        Route::get('/get-data/{id}', 'getDataDetail')->name('.get_data');
    });

    Route::prefix('kelola')->name('.kelola')->controller(LowonganMagangLkmController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/show', 'show')->name('.show');
        Route::get('/detail/{id}', 'detail')->name('.detail');
        Route::get('detail/matakuliah/{id}', 'detailMatakuliah')->name('.detail_mk');
        Route::post('/approved/{id}', 'approved')->name('.approved')->middleware('permission:kelola_lowongan_lkm.approval');
        Route::post('/rejected/{id}', 'rejected')->name('.rejected')->middleware('permission:kelola_lowongan_lkm.approval');
        Route::post('/status/{id}', 'status')->name('.status');
    });
});

Route::prefix('anggota-tim')->name('pegawaiindustri')->controller(PegawaiIndustriController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:anggota_tim.view');
    Route::get('/show', 'show')->name('.show')->middleware('permission:anggota_tim.view');
    Route::post('/store', 'store')->name('.store')->middleware('permission:anggota_tim.create');
    Route::get('/edit/{id}', 'edit')->name('.edit')->middleware('permission:anggota_tim.update');
    Route::post('/update/{id}', 'update')->name('.update')->middleware('permission:anggota_tim.update');
    Route::post('/status/{id}', 'status')->name('.status')->middleware('permission:anggota_tim.update');
    Route::post('reset-password/{id}' , 'resetPassword')->name('.reset_password')->middleware('permission:anggota_tim.reset_password');
});

// Route::prefix('jadwal-seleksi-mitra')->name('jadwal_seleksi')->controller(JadwalSeleksiController::class)->group(function () {
//     Route::get('/', 'index');
//     Route::get('get-data', 'getData')->name('.get_data');
//     Route::get('detail/{id}', 'detail')->name('.detail');
//     Route::get('detail/get-data/{id}', 'getDetailData')->name('.get_data_detail');
//     Route::get('detail/{id_lowongan}/mahasiswa/{id_pendaftaran}', 'detailMahasiswa')->name('.detail_mahasiswa');
//     Route::post('detail/{id}/set-jadwal', 'setJadwal')->name('.set_jadwal');
//     Route::post('detail/approval/{id}', 'approval')->name('.approval');
// });

// Route::prefix('jadwal-seleksi')->group(function () {

//     Route::prefix('/lowongan')->group(function () {
//         Route::get('/{id_industri}', [App\Http\Controllers\LowonganJadwalController::class, 'index'])->name('jadwal.index');
//     });

//     Route::prefix('/lanjutan')->group(function () {
//         Route::get('/{id_lowongan}', [App\Http\Controllers\JadwalSeleksiController::class, 'index'])->name('seleksi.index');
//         Route::get('/show/{id}', [App\Http\Controllers\JadwalSeleksiController::class, 'show'])->name('seleksi.show');
//         Route::post('/store', [App\Http\Controllers\JadwalSeleksiController::class, 'store'])->name('seleksi.store');
//         Route::get('/detail/{id}', [App\Http\Controllers\JadwalSeleksiController::class, 'detail'])->name('seleksi.detail');
//         Route::post('/update/{id}', [App\Http\Controllers\JadwalSeleksiController::class, 'update'])->name('seleksi.update');
//         Route::get('/kirim-email', [App\Http\Controllers\MailController::class, 'index'])->name('seleksi.email');
//     });
// });

Route::prefix('profile-perusahaan')->name('profile_company')->controller(ProfileCompanyController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/{id}', 'update')->name('.update');
    Route::get('/edit/{id}', 'edit')->name('.edit');
});

Route::prefix('assign-pembimbing')->name('assign_pembimbing')->controller(AssignPembimbingController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:assign_pembimbing.view');
    Route::get('/show', 'show')->name('.show')->middleware('permission:assign_pembimbing.view');
    Route::post('assign-pembimbing-lapangan', 'assignPemLapangan')->name('.assign_pem_lapangan')->middleware('permission:assign_pembimbing.assign');
});

Route::prefix('company')->group(function () {
    Route::prefix('summary-profile')->controller()->group(function () {
        Route::get('/', [App\Http\Controllers\SummaryProfileController::class, 'index'])->name('summary_profile.index');
        Route::put('/{id}', [App\Http\Controllers\KelolaMitraController::class, 'update']);
        Route::get('/edit/{id}', [App\Http\Controllers\KelolaMitraController::class, 'edit']);
    });

});

Route::prefix('template-email')->name('template_email')->controller(MasterEmailController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:template_email.view');
    Route::get('/show', 'show')->name('.show')->middleware('permission:template_email.view');
    Route::get('/create', 'create')->name('.create')->middleware('permission:template_email.create');
    Route::post('/store', 'store')->name('.store')->middleware('permission:template_email.create');
});


Route::prefix('kelola-mahasiswa-magang')->name('kelola_magang_pemb_lapangan')->controller(LogbookPemLapController::class)->group(function () {
    Route::get('/', 'viewList')->middleware('permission:kelola_magang_pemb_lapangan.view');
    Route::get('get-data', 'getData')->name('.get_data')->middleware('permission:kelola_magang_pemb_lapangan.view');
    Route::get('logbook/{id}', 'viewLogbook')->name('.logbook')->middleware('permission:kelola_magang_pemb_lapangan.view');
    Route::post('logbook/approval/{id}', 'approval')->name('.approval')->middleware('permission:kelola_magang_pemb_lapangan.approval');
    Route::get('input-nilai/{id}', 'viewInputNilai')->name('.input_nilai')->middleware('permission:kelola_magang_pemb_lapangan.set_nilai');
    Route::post('input-nilai/store/{id}', 'storeNilai')->name('.store_nilai')->middleware('permission:kelola_magang_pemb_lapangan.set_nilai');
    Route::post('delete-mhs/{id}', 'deleteMhs')->name('.delete_mhs')->middleware('permission:kelola_magang_pemb_lapangan.delete_mhs');
});

Route::prefix('dashboard/company')->name('dashboard_company')->controller(DashboardMitraController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('get-data', 'getData')->name('.get_data');
})->middleware('permission:dashboard.dashboard_mitra');
