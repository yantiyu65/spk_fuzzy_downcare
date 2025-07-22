<?php

use App\Models\Kriteria;
use App\Helpers\FuzzyLogicHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\DataUserController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PerhitunganController;
use App\Http\Controllers\Admin\SubKriteriaController;
use App\Http\Controllers\User\PerkembanganAnakController;
use App\Http\Controllers\User\RekomendasiTerapiController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Dashboard
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// User Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});
// admin

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('admin.perhitungan');
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('admin.kriteria');
    Route::post('/kriteria', [KriteriaController::class, 'store'])->name('admin.kriteria.store');
    Route::put('kriteria/{id}', [KriteriaController::class, 'update'])->name('admin.kriteria.update');
    Route::delete('kriteria/{id}', [KriteriaController::class, 'destroy'])->name('admin.kriteria.destroy');
    Route::get('/sub-kriteria', [SubKriteriaController::class, 'index'])->name('admin.subkriteria');
    Route::post('/sub-kriteria', [SubKriteriaController::class, 'store'])->name('admin.subkriteria.store');
    Route::put('/sub-kriteria/{id}', [SubKriteriaController::class, 'update'])->name('admin.subkriteria.update');
    Route::delete('/sub-kriteria/{id}', [SubKriteriaController::class, 'destroy'])->name('admin.subkriteria.destroy');
    
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('admin.laporan.cetak');

    Route::get('/data-user', [DataUserController::class, 'index'])->name('admin.datauser');
    Route::post('/data-user', [DataUserController::class, 'store'])->name('admin.datauser.store');
    Route::put('data-user/{id}', [DataUserController::class, 'update'])->name('admin.datauser.update');
    Route::delete('data-user/{id}', [DataUserController::class, 'destroy'])->name('admin.datauser.destroy');

});
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/perkembangan-anak', [PerkembanganAnakController::class, 'index'])->name('user.perkembangan-anak.index');
    Route::post('/perkembangan-anak', [PerkembanganAnakController::class, 'store'])->name('user.perkembangan-anak.store');
    Route::get('/perkembangan-anak/create', [PerkembanganAnakController::class, 'create'])->name('user.perkembangan-anak.create');
    Route::get('/perkembangan-anak/{id}', [PerkembanganAnakController::class, 'show'])->name('user.perkembangan-anak.show');
    Route::get('/rekomendasi', function () {
        return view('user.perkembangan-anak.rekomendasi');
    })->name('user.rekomendasi');
    Route::post('/get-subkriteria-by-usia', [PerkembanganAnakController::class, 'getSubKriteriaByUsia'])->name('get.subkriteria.usia');
    Route::get('/rekomendasi', [RekomendasiTerapiController::class, 'index'])->name('user.rekomendasi');
    
});


Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login'); // ganti sesuai login route kamu
});


require __DIR__.'/auth.php';
