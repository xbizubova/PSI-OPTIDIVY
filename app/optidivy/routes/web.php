<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RezervaciaController;
use App\Http\Controllers\OptometristaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UcetController;

// ── Verejné ──────────────────────────────────────────
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produkty/{kategoria}', [ProductController::class, 'kategoria'])->name('produkty');
Route::post('/produkty/okuliare/{frame}', [ProductController::class, 'selectFrame'])->name('produkty.selectFrame');
Route::post('/produkty/lenses/{lense}', [ProductController::class, 'makeGlasses'])->name('produkty.makeGlasses');
Route::get('/rezervacia', [RezervaciaController::class, 'index'])->name('rezervacia');
Route::middleware('auth')->group(function () {
    Route::get('/kosik',                [CartController::class, 'index'])->name('kosik');
    Route::post('/kosik/{stock}',       [CartController::class, 'add'])->name('kosik.add');
    Route::patch('/kosik/{item}',       [CartController::class, 'update'])->name('kosik.update');
    Route::delete('/kosik/{item}',      [CartController::class, 'destroy'])->name('kosik.destroy');
});
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
