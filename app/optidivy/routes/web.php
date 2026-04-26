<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RezervaciaController;
use App\Http\Controllers\OptometristaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UcetController;

// ── Verejné ──────────────────────────────────────────
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produkty/{kategoria}', [ProductController::class, 'kategoria'])->name('produkty');
Route::get('/rezervacia', [RezervaciaController::class, 'index'])->name('rezervacia');
Route::get('/kosik', fn() => view('kosik', ['cartItems' => [], 'total' => 0]))->name('kosik');
Route::get('/kontakt', fn() => view('kontakt'))->name('kontakt');
Route::get('/donaska', fn() => view('donaska'))->name('donaska');
Route::get('/platba',  fn() => view('platba'))->name('platba');

// ── Rezervácia – uloženie ─────────────────────────────
Route::post('/rezervacia', [RezervaciaController::class, 'store'])
    ->middleware('auth')->name('rezervacia.store');

// ── Klient ────────────────────────────────────────────
Route::middleware(['auth', 'klient'])->group(function () {
    Route::get('/ucet',  [UcetController::class, 'index'])->name('ucet');
    Route::patch('/ucet', [UcetController::class, 'update'])->name('ucet.update');
});
// ── Optometrista ──────────────────────────────────────
Route::middleware(['auth', 'optometrista'])->group(function () {
    Route::get('/optometrista', [OptometristaController::class, 'index'])
        ->name('optometrista');
    Route::post('/optometrista/predpis', [OptometristaController::class, 'storePrescription'])
        ->name('optometrista.prescription.store');
});

// ── Auth routes (Breeze) ──────────────────────────────
require __DIR__.'/auth.php';
