<?php

use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::post('/', [PelangganController::class, 'store'])->name('pelanggan.store');
Route::get('/{id}', [PelangganController::class, 'show'])->name('pelanggan.show');
Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');