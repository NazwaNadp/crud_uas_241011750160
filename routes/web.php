<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DessertController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

/*
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('keranjang')->name('keranjang.')->group(function () {
    Route::get('/', [KeranjangController::class, 'index'])->name('index');
    Route::post('/tambah', [KeranjangController::class, 'tambah'])->name('tambah');
    Route::post('/update/{key}', [KeranjangController::class, 'update'])->name('update');
    Route::post('/hapus/{key}', [KeranjangController::class, 'hapus'])->name('hapus');
    Route::post('/kosongkan', [KeranjangController::class, 'kosongkan'])->name('kosongkan');
    Route::get('/checkout', [KeranjangController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [KeranjangController::class, 'prosesCheckout'])->name('prosesCheckout');
});

/*
*/
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DessertController::class, 'index'])->name('dashboard');

    Route::get('/desserts/export-pdf', [DessertController::class, 'exportPdf'])->name('desserts.export-pdf');
    Route::resource('desserts', DessertController::class)->except(['index'])->names('desserts');
    Route::get('/desserts', [DessertController::class, 'index'])->name('desserts.index');

    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::post('/pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::delete('/pesanan/{pesanan}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
});
