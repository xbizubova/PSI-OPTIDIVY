<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RezervaciaController;
use App\Http\Controllers\OptometristaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UcetController;
use App\Http\Controllers\CheckoutController;
use App\Models\Orders\Cart;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\TechnikController;

// ── Verejné ──────────────────────────────────────────
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produkty/{kategoria}', [ProductController::class, 'kategoria'])->name('produkty');
Route::post('/produkty/okuliare/{frame}', [ProductController::class, 'selectFrame'])->name('produkty.selectFrame');
Route::post('/produkty/lenses/{lense}', [ProductController::class, 'makeGlasses'])->name('produkty.makeGlasses');
Route::get('/rezervacia', [RezervaciaController::class, 'index'])->name('rezervacia');
Route::delete('/rezervacia/{id}/cancel', [RezervaciaController::class, 'cancel'])->name('rezervacia.cancel');
Route::middleware('auth')->group(function () {
    Route::get('/kosik',                [CartController::class, 'index'])->name('kosik');
    Route::post('/kosik/{stock}',       [CartController::class, 'add'])->name('kosik.add');
    Route::patch('/kosik/{item}',       [CartController::class, 'update'])->name('kosik.update');
    Route::delete('/kosik/{item}',      [CartController::class, 'destroy'])->name('kosik.destroy');
});
Route::get('/kontakt', function() {
    $cart = Cart::firstOrCreate(['customer_id' => auth()->id()]);
    $cartItems = $cart->items()->with([
        'product' => function($query) {},
    ])->get()->each(function($item) {
        if ($item->product instanceof \App\Models\Glasses) {
            $item->product->load('frame.stock', 'lense.stock');
        }
    });
    $total = $cart->getTotal();
    return view('kontakt', compact('cartItems', 'total'));
})->middleware('auth')->name('kontakt');

Route::post('/kontakt', [CheckoutController::class, 'storeKontakt'])->middleware('auth')->name('kontakt.store');

Route::get('/donaska', function() {
    $cart = Cart::firstOrCreate(['customer_id' => auth()->id()]);
    $cartItems = $cart->items()->with([
        'product' => function($query) {},
    ])->get()->each(function($item) {
        if ($item->product instanceof \App\Models\Glasses) {
            $item->product->load('frame.stock', 'lense.stock');
        }
    });
    $total = $cart->getTotal();
    return view('donaska', compact('cartItems', 'total'));
})->middleware('auth')->name('donaska');

Route::post('/donaska', [CheckoutController::class, 'storeDonaska'])->middleware('auth')->name('donaska.store');

Route::get('/platba', function() {
    $cart = Cart::firstOrCreate(['customer_id' => auth()->id()]);
    $cartItems = $cart->items()->with([
        'product' => function($query) {},
    ])->get()->each(function($item) {
        if ($item->product instanceof \App\Models\Glasses) {
            $item->product->load('frame.stock', 'lense.stock');
        }
    });
    $total = $cart->getTotal();
    $donaska = session('checkout_donaska');
    return view('platba', compact('cartItems', 'total', 'donaska'));
})->middleware('auth')->name('platba');

Route::post('/platba', [CheckoutController::class, 'storePlatba'])->middleware('auth')->name('platba.store');

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
// ── Technik ──────────────────────────────────────
Route::middleware(['auth', 'technik'])->group(function () {
    Route::get('/technik', [TechnikController::class, 'index'])->name('technik');
    Route::get('/technik/{order}', [TechnikController::class, 'show'])->name('technik.show');
    Route::patch('/technik/{order}/status', [TechnikController::class, 'updateStatus'])->name('technik.status');
    Route::post('/technik/{order}/consume/{stock}', [TechnikController::class, 'consumeOne'])->name('technik.consume.one');
    Route::post('/technik/{order}/consume', [TechnikController::class, 'completeOrder'])->name('technik.consume');
});
// ── Auth routes (Breeze) ──────────────────────────────
Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('/manager', [ManagerController::class, 'index'])->name('manager');
    Route::post('/manager/stocks/{stock}/order', [ManagerController::class, 'orderFromSupplier'])
        ->name('manager.stocks.order');
});

require __DIR__.'/auth.php';
