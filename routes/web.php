<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;

Route::resource('orders', OrderController::class);

// For updating order status
Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
