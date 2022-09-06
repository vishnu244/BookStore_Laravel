<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('changePassword',[PasswordController::class,'changePassword']);
Route::post('forgotPassword',[PasswordController::class,'forgotPassword']);
Route::post('resetPassword',[PasswordController::class,'resetPassword']);

Route::POST('registration',[UserController::class,'Registerdata']);
Route::POST('login',[UserController::class,'login']);
Route::POST('logout',[UserController::class,'logout']);
