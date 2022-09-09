<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/first', \App\Http\Controllers\GetFirstController::class);
Route::get('/company', \App\Http\Controllers\GetCompanyController::class);
Route::post('/user', '\App\Http\Controllers\UserController@createUser');
Route::post('/user/login','\App\Http\Controllers\UserController@loginUser');
Route::post('/company', '\App\Http\Controllers\CompanyController@createCompany');
Route::post('/company/login','\App\Http\Controllers\CompanyController@loginCompany');
