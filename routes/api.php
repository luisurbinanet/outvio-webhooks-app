<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OutvioWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/webhooks/orders', [OutvioWebhookController::class, 'orders']);
Route::post('/webhooks/shipping', [OutvioWebhookController::class, 'shipping']);
Route::post('/webhooks/tracking', [OutvioWebhookController::class, 'tracking']);

