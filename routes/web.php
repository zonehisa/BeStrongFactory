<?php

use App\Http\Controllers\IncomingShipmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OutgoingShipmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockHistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('inventories', InventoryController::class);
    Route::resource('incoming_shipments', IncomingShipmentController::class);
    Route::resource('outgoing_shipments', OutgoingShipmentController::class);
    Route::resource('stock_histories', StockHistoryController::class);
    Route::get('/stock-histories', [StockHistoryController::class, 'index'])->name('stock_histories.index');
});

require __DIR__ . '/auth.php';
