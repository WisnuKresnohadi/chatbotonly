<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('profile-detail')->name('profile_detail')->controller(ProfileController::class)->group(function(){
    Route::get('/','index')->name('.informasi-pribadi');
    Route::get('show', 'show')->name('.show');
    Route::post('change-foto', 'gantiFoto')->name('.ganti_foto');
    Route::post('delete-foto', 'deleteFoto')->name('.delete_foto');
    Route::post('change-password', 'changePassword')->name('.change_password');
    Route::post('update-data', 'updateData')->name('.update_data');
});
