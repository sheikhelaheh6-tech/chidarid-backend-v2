<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\QRCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('auth/register',[AuthController::class,'register']);
Route::post('auth/verify-otp',[AuthController::class,'verifyOtp']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::put('profile',[ProfileController::class,'update']);
    Route::apiResource('categories',CategoryController::class);
    Route::apiResource('items',ItemController::class);

    Route::get('/qrcode/generate/{item}', [QRCodeController::class, 'generate']);
    Route::get('/qrcode/{id}', [QRCodeController::class, 'show']);

    Route::post('logout', [AuthController::class, 'logout']);

});
