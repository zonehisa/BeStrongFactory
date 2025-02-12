<?php

use App\Http\Controllers\IncomingShipmentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OutgoingShipmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('inventories.index');
    }
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('inventories', InventoryController::class);
    Route::resource('incoming_shipments', IncomingShipmentController::class);
    Route::resource('outgoing_shipments', OutgoingShipmentController::class);
    Route::resource('stock_histories', StockHistoryController::class);
    Route::get('/stock-histories', [StockHistoryController::class, 'index'])->name('stock_histories.index');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__ . '/auth.php';
