<?php

use Illuminate\Support\Facades\Route;

// daftar use controller harus di paling atas
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MultipleUploadController;


// ROUTE UTAMA
Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: ' . $param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'NIM saya: ' . $param1;
});

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/home',[HomeController::class,'index']);
Route::get('/pegawai', [PegawaiController::class, 'index']);


// QUESTION STORE
Route::post('/question/store', [QuestionController::class, 'store'])
        ->name('question.store');


// RESOURCE PELANGGAN
Route::resource('/pelanggan', PelangganController::class);


// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


// ADMIN GROUP
Route::resource('/user', UserController::class);


// MULTIPLE UPLOAD ROUTE
Route::post('/multiple-upload', [MultipleUploadController::class, 'store'])
        ->name('multipleupload.store');

Route::delete('/multiple-upload/{id}', [MultipleUploadController::class, 'destroy'])
        ->name('multipleupload.destroy');


// 🔥 STREAMING ROUTE AGAR VIDEO BISA DIPLAY
Route::get('/stream/{filename}', function($filename) {

    $path = storage_path("app/public/uploads/pelanggan/" . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path, [
        'Content-Type' => mime_content_type($path),
        'Content-Disposition' => 'inline'
    ]);

})->where('filename', '.*');
