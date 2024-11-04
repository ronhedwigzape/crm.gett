<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\FlightTicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatusController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('tour-packages', TourPackageController::class);
    Route::apiResource('flight-tickets', FlightTicketController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('airlines', AirlineController::class);
    Route::apiResource('branches', BranchController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('statuses', StatusController::class);
});
