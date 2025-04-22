<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CreditController;
use Illuminate\Support\Facades\Route;

Route::post('/clients', [ClientController::class, 'store']);
Route::post('/credits/check', [CreditController::class, 'check']);
Route::post('/credits/issue', [CreditController::class, 'issue']);
