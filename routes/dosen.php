<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApprovalMahasiswaController;
use App\Http\Controllers\ApprovalMahasiswaKaprodiController;
use App\Http\Controllers\Logbook\KelolaMahasiswaPemAkademikController;
use App\Http\Controllers\DataMahasiswaMagang\DataMahasiswaMagangDosenController;
use App\Http\Controllers\DataMahasiswaMagang\DataMahasiswaMagangKaprodiController;

// Dosen Wali
Route::prefix('approval-mahasiswa')->name('approval_mahasiswa_doswal')->controller(ApprovalMahasiswaController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('get-data', 'getData')->name('.get_data');
    Route::get('detail/{id}', 'detail')->name('.detail');
    Route::post('approval/{id}', 'approval')->name('.approval');
    Route::post('approvals', 'approvals')->name('.approvals');
});
Route::prefix('data-mahasiswa-magang-dosen')->name('mahasiswa_magang_dosen')->controller(DataMahasiswaMagangDosenController::class)->group(function () {
    Route::get('/', 'indexDosen');
    Route::get('get-data', 'getData')->name('.get_data');
});

// Kaprodi
Route::prefix('approval-mahasiswa-kaprodi')->name('approval_mahasiswa_kaprodi')->controller(ApprovalMahasiswaKaprodiController::class)->group(function () {
    Route::get('/', 'index')->middleware('permission:approval_mhs_kaprodi.view');
    Route::get('get-data', 'getData')->name('.get_data')->middleware('permission:approval_mhs_kaprodi.view');
    Route::get('detail/{id}', 'detail')->name('.detail')->middleware('permission:approval_mhs_kaprodi.view');
    Route::post('approval/{id}', 'approval')->name('.approval')->middleware('permission:approval_mhs_kaprodi.approval');
    Route::post('approvals', 'approvals')->name('.approvals')->middleware('permission:approval_mhs_kaprodi.approval');
});

Route::prefix('data-mahasiswa-magang-kaprodi')->name('mahasiswa_magang_kaprodi')->controller(DataMahasiswaMagangKaprodiController::class)->group(function () {
    Route::get('/', 'indexKaprodi')->middleware('permission:data_mahasiswa_magang_kaprodi.view');
    Route::get('get-data', 'getData')->name('.get_data')->middleware('permission:data_mahasiswa_magang_kaprodi.view');
    Route::post('assign-pembimbing-akademik', 'assignPemAkademik')->name('.assign_pem_akademik')->middleware('permission:data_mahasiswa_magang_kaprodi.assign_pembimbing');
});

Route::prefix('kelola-mahasiswa')->name('kelola_mhs_pemb_akademik')->controller(KelolaMahasiswaPemAkademikController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('get-data', 'getData')->name('.get_data');
    Route::get('logbook/{id}', 'viewLogbook')->name('.logbook');
    Route::get('input-nilai/{id}', 'inputNilai')->name('.view_nilai');
    Route::get('view-input-nilai/{id}', 'viewInputNilai')->name('.view_input_nilai');
    Route::post('store-nilai/{id}', 'storeNilaiPembAkademik')->name('.store_nilai');
});
