<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutvioWebhookController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/logs/orders', [OutvioWebhookController::class, 'readLog'])->name('logs.orders')->defaults('type', 'orders');
    Route::get('/logs/shipping', [OutvioWebhookController::class, 'readLog'])->name('logs.shipping')->defaults('type', 'shipping');
    Route::get('/logs/tracking', [OutvioWebhookController::class, 'readLog'])->name('logs.tracking')->defaults('type', 'tracking');
});
