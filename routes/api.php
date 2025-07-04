<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\GetWalletRecurringTransferLogsController;
use App\Http\Controllers\Api\V1\GetWalletRecurringTransfersController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\SendMoneyController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/login', LoginController::class)->middleware(['guest:sanctum', 'throttle:api.login']);

Route::middleware(['auth:sanctum', 'throttle:api'])->prefix('v1')->group(function () {
    Route::get('/account', AccountController::class);
    Route::post('/wallet/send-money', SendMoneyController::class);
    Route::get('/wallet/recurring-transfer', GetWalletRecurringTransfersController::class);
    Route::get('/wallet/recurring-transfer/{id}/logs', GetWalletRecurringTransferLogsController::class);
});
