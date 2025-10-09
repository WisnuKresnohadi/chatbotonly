<?php

use App\Http\Controllers\WawancaraController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TrialchatController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\HasilWawancaraController;
use App\Http\Controllers\KelolaPenggunaController;
use App\Http\Controllers\MitraPerusahaanController;
use App\Http\Controllers\JadwalSeleksiAdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\KelolaSemuaPenggunaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// landingpage

Route::controller(HomeController::class)->name('dashboard')->group(function () {
    Route::get('/', 'index');
    Route::get('detail-lowongan/{id}', 'detailLowongan')->name('.detail-lowongan');
});

Route::get('/forgot-pass', function () {
    return view('errors.forgot-password');
})->name('forgot-pass');

//admin
//super admin
Route::get('/super-admin', [App\Http\Controllers\SuperAdminController::class, 'index'])->middleware(['auth'])->name('dashboard.superadmin');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::prefix('register')->name('register')->controller(RegisteredUserController::class)->group(function () {
    Route::get('set-password/{token}', 'newPassword')->name('.set-password');
    Route::post('/set-password', 'storeNewPassword')->name('.set-password.store');
    Route::get('{role}/successed/{email}', function ($role, $email) {
        $email = Crypt::decryptString($email);
        if (in_array($role, ['dosen', 'user'])) {
            return view('auth/message-verify-email_internal', compact('email'));
        } else {
            return view('auth.message-verify-email', compact('email'));
        }
    })->name('.successed');
});

require __DIR__ . '/auth.php';

Route::prefix('apply-lowongan')->name('apply_lowongan')->group(function () {
    Route::get('/', [App\Http\Controllers\ApplyLowonganFakultasController::class, 'index']);
    Route::get('/detail/{id}', [App\Http\Controllers\ApplyLowonganFakultasController::class, 'show'])->name('.detail');
    Route::get('/lamar/{id}', [App\Http\Controllers\ApplyLowonganFakultasController::class, 'lamar'])->name('.detail.lamar');
    Route::get('/persentase/{id}', [App\Http\Controllers\ApplyLowonganFakultasController::class, 'persentase'])->name('persentase.index');
    Route::post('/apply/{id}', [App\Http\Controllers\ApplyLowonganFakultasController::class, 'apply'])->name('.apply');
});

Route::middleware('auth')->group(function () {
    require __DIR__ . '/master_data.php';
    require __DIR__ . '/kemitraan.php';
    require __DIR__ . '/mahasiswa.php';
    require __DIR__ . '/dosen.php';
    require __DIR__ . '/profile.php';

    ;
Route::post('/chat/trial', [TrialchatController::class, 'sendMessageTrial'])->name('chat.sendTrial');

    Route::middleware('permission:dashboard.dashboard_admin')->get('dashboard/admin', function () {
        return view('dashboard.admin.index');
    })->name('dashboard_admin');

    Route::prefix('dashboard/admin')->name('dashboard_admin')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('get-data', 'getData')->name('.get_data');
    })->middleware('permission:dashboard.dashboard_admin');

    Route::prefix('kelola-pengguna')->name('kelola_pengguna')->controller(KelolaPenggunaController::class)->group(function () {
        Route::get('/', 'index')->middleware('permission:kelola_pengguna.view');
        Route::get('get-data', 'getData')->name('.get_data')->middleware('permission:kelola_pengguna.view');
        Route::post('store', 'store')->name('.store')->middleware('permission:kelola_pengguna.create');
        Route::get('edit/{id}', 'edit')->name('.edit')->middleware('permission:kelola_pengguna.update');
        Route::post('update/{id}', 'update')->name('.update')->middleware('permission:kelola_pengguna.update');
        Route::post('update-status/{id}', 'updateStatus')->name('.update_status')->middleware('permission:kelola_pengguna.update');
        Route::post('reset-password/{id}', 'resetPassword')->name('.reset_password')->middleware('permission:kelola_pengguna.reset_password');
    });

    Route::prefix('kelola-semua-pengguna')->name('kelola_semua_pengguna')->controller(KelolaSemuaPenggunaController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('show', 'getData')->name('.show');
        Route::get('edit/{id}', 'edit')->name('.edit');
        Route::post('update/{id}', 'update')->name('.update');
    });

    Route::prefix('roles')->name('roles')->controller(KonfigurasiController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('show', 'show')->name('.show');
        Route::post('store', 'store')->name('.store');
        Route::post('update/{id}', 'update')->name('.update');
        Route::get('edit/{id}', 'edit')->name('.edit');
        Route::post('status/{id}', 'status')->name('.status');
});

    Route::prefix('data-kandidat')->middleware('can:only.lkm')->group(function () {
        Route::get('/', [App\Http\Controllers\DatakandidatController::class, 'index'])->name('data-kandidat.index');
        Route::get('/show', [App\Http\Controllers\DatakandidatController::class, 'show'])->name('data-kandidat.show');
        Route::post('/store', [App\Http\Controllers\DatakandidatController::class, 'store'])->name('data-kandidat.store');
        Route::post('/update/{id}', [App\Http\Controllers\DatakandidatController::class, 'update'])->name('data-kandidat.update');
        Route::get('/edit/{id}', [App\Http\Controllers\DatakandidatController::class, 'edit'])->name('data-kandidat.edit');
        Route::post('/status/{id}', [App\Http\Controllers\DatakandidatController::class, 'status'])->name('data-kandidat.status');
        Route::get('/list-kandidat/{id_univ}', [App\Http\Controllers\DatakandidatController::class, 'list_kandidat'])->name('data-kandidat.list_kandidat');
    });

    Route::prefix('informasi')->middleware([RoleMiddleware::class])->group(function () {
        Route::prefix('/lowongan')->group(function () {
            Route::get('/{id_industri}', [App\Http\Controllers\InformasiLowonganController::class, 'index'])->name('lowongan.index');
            Route::get('/show', [App\Http\Controllers\InformasiLowonganController::class, 'show'])->name('lowongan.show');
            Route::post('/store', [App\Http\Controllers\InformasiLowonganController::class, 'store'])->name('lowongan.store');
            Route::post('/status/{id}', [App\Http\Controllers\InformasiLowonganController::class, 'status'])->name('lowongan.status');
            Route::get('/add/{id}', [App\Http\Controllers\InformasiLowonganController::class, 'add'])->name('lowongan.add');
            Route::post('/date/{id}', [App\Http\Controllers\InformasiLowonganController::class, 'date'])->name('lowongan.date');
        });

        // Route::prefix('mitra')->middleware('can:only.lkm')->group(function () {
        //     Route::get('/', [App\Http\Controllers\InformasiMitraController::class, 'index'])->name('mitra.index');
        //     Route::get('/show', [App\Http\Controllers\InformasiMitraController::class, 'show']);
        //     Route::post('/store', [App\Http\Controllers\InformasiMitraController::class, 'store'])->name('mitra.store');
        //     Route::post('/status/{id}', [App\Http\Controllers\InformasiMitraController::class, 'status'])->name('mitra.status');
        //     Route::post('/update/{id}', [App\Http\Controllers\InformasiMitraController::class, 'update'])->name('mitra.update');
        //     Route::get('/edit/{id}', [App\Http\Controllers\InformasiMitraController::class, 'edit'])->name('mitra.edit');
        // });
        Route::prefix('kandidat/')->group(function () {
            Route::get('/{id_lowongan}', [App\Http\Controllers\InformasiKandidatController::class, 'index'])->name('kandidat.index');
            Route::get('/detail/{id_pendaftaran}', [App\Http\Controllers\InformasiKandidatController::class, 'detail'])->name('kandidat.detail');
            Route::get('/show/{id}', [App\Http\Controllers\InformasiKandidatController::class, 'show'])->name('kandidat.show');
            Route::post('/store', [App\Http\Controllers\InformasiKandidatController::class, 'store'])->name('kandidat.store');
            Route::post('/status', [App\Http\Controllers\InformasiKandidatController::class, 'status'])->name('kandidat.status');
            Route::post('/update/{id}', [App\Http\Controllers\InformasiKandidatController::class, 'update'])->name('kandidat.update');
            Route::get('/edit/{id}', [App\Http\Controllers\InformasiKandidatController::class, 'edit'])->name('kandidat.edit');
        });
    });

    // Route::prefix('kelola')->group(function () {
    //     Route::prefix('lowongan/mitra')->group(function () {
    //         Route::get('/{id}', [App\Http\Controllers\LowonganMagangController::class, 'index'])->name('lowongan-magang.index.mitra');
    //         Route::post('/show', [App\Http\Controllers\LowonganMagangController::class, 'show'])->name('lowongan-magang.show.mitra');
    //         Route::get('/create/{id}', [App\Http\Controllers\LowonganMagangController::class, 'create'])->name('lowongan-magang.create');
    //         Route::post('/store', [App\Http\Controllers\LowonganMagangController::class, 'store'])->name('lowongan-magang.store');
    //         Route::get('/detail/{id}', [App\Http\Controllers\LowonganMagangController::class, 'detail'])->name('lowongan-magang.detail');
    //         Route::get('/edit/{id}', [App\Http\Controllers\LowonganMagangController::class, 'edit'])->name('lowongan-magang.edit');
    //         Route::post('/update/{id}', [App\Http\Controllers\LowonganMagangController::class, 'update'])->name('lowongan-magang.edit');
    //     });
    // });

    Route::prefix('mandiri')->group(function () {
        Route::prefix('approve-mandiri')->middleware('can:only.lkm')->group(function () {
            Route::get('/', [App\Http\Controllers\ApproveMandiriController::class, 'index'])->name('approve_mandiri.index');
            Route::get('/show/{statusapprove}', [App\Http\Controllers\ApproveMandiriController::class, 'show'])->name('approve_mandiri.show');
            Route::post('/approved/{id}', [App\Http\Controllers\ApproveMandiriController::class, 'approved'])->name('approve_mandiri.approved');
            Route::post('/rejected/{id}', [App\Http\Controllers\ApproveMandiriController::class, 'rejected'])->name('approve_mandiri.rejected');
        });
    });

    Route::prefix('/pengajuan/surat')->group(function () {
        Route::get('/', [App\Http\Controllers\KonfirmasiMandiriController::class, 'index'])->name('mandiri.index');
        Route::post('/show', [App\Http\Controllers\KonfirmasiMandiriController::class, 'show'])->name('mandiri.show');
        Route::post('/store', [App\Http\Controllers\KonfirmasiMandiriController::class, 'store'])->name('mandiri.store');
        Route::get('/detail/{id}', [App\Http\Controllers\KonfirmasiMandiriController::class, 'detail'])->name('mandiri.detail');
        Route::post('/update/{id}', [App\Http\Controllers\KonfirmasiMandiriController::class, 'update'])->name('mandiri.update');
        Route::get('/edit/{id}', [App\Http\Controllers\KonfirmasiMandiriController::class, 'edit'])->name('mandiri.edit');
        Route::post('/status/{id}', [App\Http\Controllers\KonfirmasiMandiriController::class, 'status'])->name('mandiri.status');
    });

    Route::prefix('jadwal-seleksi-lkm')->name('jadwal_seleksi_lkm')->middleware('permission:jadwal_seleksi_lkm.view')->controller(JadwalSeleksiAdminController::class)->group(function () {
        Route::get('/', 'listMitra');
        Route::get('get-mitra', 'getListMitra')->name('.get_mitra');

        Route::get('mitra/{id}', 'index')->name('.list_lowongan');
        Route::get('get-data/{id}', 'getData')->name('.get_data');

        Route::get('detail/{id}', 'detail')->name('.detail');
        Route::get('detail/get-data/{id}', 'getDetailData')->name('.get_data_detail');

        Route::get('detail/{id_lowongan}/mahasiswa/{id_pendaftaran}', 'detailMahasiswa')->name('.detail_mahasiswa');
    });


    // Route::prefix('/apply')->group(function () {
    //     Route::get('/', [App\Http\Controllers\DetailLowonganController::class, 'index'])->name('detail-lowongan.index');
    // });
});


Route::prefix('daftar-perusahaan')->name('daftar_perusahaan')->group(function () {
    Route::get('/', [MitraPerusahaanController::class, 'index']);
    Route::get('/detail/{id}', [MitraPerusahaanController::class, 'show'])->name('.detail');
    Route::get('/filter', [MitraPerusahaanController::class, 'filter'])->name('.filter');
    Route::get('/detail-lowongan/{id}', [MitraPerusahaanController::class, 'detailLowongan'])->name('.detail-lowongan');
});

// Route::get('/pengaturan', function () {
//     return view('pengaturan_akun.pengaturan');
// });

// Route::get('/magang_fakultas', function () {
//     return view('program_magang.magang');
// });

// Route::get('/informasi/magang', function () {
//     return view('program_magang.informasi_magang');
// });

// Route::get('/lowongan-magang-tersimpan', function () {
//     return view('program_magang.lowongan_magang_tersimpan');
// });

// Route::get('/informasi/pribadi', function () {
//     return view('profile.informasi_pribadi');
// });

// Route::get('/detail-informasi-pengalaman', function () {
//     return view('profile.pengalaman');
// });

// Route::get('/detail-informasi-dokumen', function () {
//     return view('profile.dokumen');
// });

// Route::get('/detail/lowongan/magang', function () {
//     return view('program_magang.detail_lowongan');
// });

// Route::get('/kegiatan_saya/lamaran_saya/status', function () {
//     return view('kegiatan_saya.lamaran_saya.status_lamaran');
// });

// Route::get('/pratinjau/diri', function () {
//     return view('apply.pratinjau');
// });

// Route::get('/cv', function () {
//     return view('mahasiswa.cv', ['active_menu' => 'CV Mahasiswa']);
// });



// Route::get('/logbook/mahasiswa', function () {
//     return view('company.logbook_mahasiswa.logbook');
// });

// Route::get('/logbook/detail', function () {
//     return view('company.logbook_mahasiswa.detail_logbook');
// });

Route::get('/aboutus/talentern', function () {
    return view('landingpage.about_us_talentern');
});

Route::get('/aboutus/techno', function () {
    return view('landingpage.about_us_techno');
});

Route::get('/aboutus/lkmfit', function () {
    return view('landingpage.about_us_lkm');
});


// Route::get('/pengajuan/magang', function () {
//     return view('pengajuan_magang.mandiri.tambah');
// });

// Route::get('/kelola/mahasiswa', function () {
//     return view('kelola_mahasiswa.index');
// });

// Route::prefix('/input/nilai/akademik')->group(function () {
//     Route::get('/', [App\Http\Controllers\InputNilaiAkademikController::class, 'index'])->name('kelola_mahasiswa_akademik.index');
//     Route::get('/show/{scored_by}', [App\Http\Controllers\KomponenPenilaianController::class, 'show']);
//     Route::post('/store', [App\Http\Controllers\InputNilaiAkademikController::class, 'store'])->name('kelola_mahasiswa_akademik.store');
//     Route::post('/update{id}', [App\Http\Controllers\InputNilaiAkademikController::class, 'update'])->name('kelola_mahasiswa_akademik.update');
//     Route::get('/edit{id}', [App\Http\Controllers\InputNilaiAkademikController::class, 'edit'])->name('kelola_mahasiswa_akademik.edit');
//     Route::post('/status/{id}', [App\Http\Controllers\InputNilaiAkademikController::class, 'status'])->name('kelola_mahasiswa_akademik.status');
// });

// Route::get('/view/logbook', function () {
//     return view('kelola_mahasiswa.kelola_mahasiswa_akademik.view_logbook');
// });

// Route::get('/verifikasi/akun', function () {
//     return view('partials_auth.verifikasi_akun');
// });

// Route::get('/status/magang', function () {
//     return view('kegiatan_saya.status_magang.index');
// });

// Route::get('kirim-email', 'App\Http\Controllers\MailController@index');

Route::post('submit-contact', [ContactController::class, 'store'])->name('submit-contact');

// Route::get('/test', function () {
//     return view('auth.message-verify-email');
// });

// Route::get('test-email', function () {
//     return view('email/verify');
// });

// Route::middleware(['auth', 'permission:data_magang.view'])->group(function () {
//     Route::get('/data-magang', function () {
//         return 'data-magang';
//     })->name('data_magang');
//     Route::get('/data-magang/show', function () {
//         return 'data-magang-show';
//     })->name('data_magang.show');
// });

//ChatBot Controller
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

// Route::get('/chat/testing', [ChatController::class, 'testPostMan']); //testing

Route::prefix('wawancara')->name('wawancara-flow')->group(function () {
    //congfig chatbot
    Route::get('/config/{id_lowongan}', [WawancaraController::class, 'config'])->name('.config');
    Route::post('/editconfig/{id_lowongan}', [WawancaraController::class, 'editconfig'])->name('.editconfig');

    Route::match(['get', 'post'], '/panduan/{id_pendaftaran}', [ChatController::class, 'index'])->name('.panduan');
    Route::get('/trial/{id_pendaftaran}', [TrialchatController::class, 'trialChat'])->name('.trial');
    Route::get('/hasilwawancara/{id_pendaftaran}', [HasilWawancaraController::class, 'viewHasilWawancara'])->name('.result');
    // Route::get('/hasilwawancara/{id_pendaftaran}', [HasilWawancaraController::class, 'viewHasilWawancara'])->middleware('permission:kelola_lowongan_mitra.view')->name('.result');
    Route::get('/syaratdanketentuan/{id_pendaftaran}', [ChatController::class, 'syaratdanketentuan'])->name('.snk');
    Route::get('/interview-main-session/{id_pendaftaran}',[ChatController::class,'chatsection'])->name('.main-session');
    Route::get('/historychat', [ChatController::class, 'historychat'])->name('.history');
    Route::post('/decreasequota', [WawancaraController::class, 'decreaseQuota'])->name('.deqreasequota');

});
