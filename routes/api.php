<?php

use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SmsController;
use GuzzleHttp\Middleware;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'auth:api'
], function () {
    // Designation routes

    Route::get('/designations', [DesignationController::class, 'index']);
    Route::post('/designations/create', [DesignationController::class, 'store']);
    Route::put('/designations/update/{id}', [DesignationController::class, 'update']);
    Route::delete('/designations/delete/{id}', [DesignationController::class, 'destroy']);


    // Employee routes

    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees/create', [EmployeeController::class, 'store']);
    Route::post('/employees/update/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/delete/{id}', [EmployeeController::class, 'destroy']);

    // Salary routes

    Route::get('/salaries', [SalaryController::class, 'index']);
    Route::post('/salary/create', [SalaryController::class, 'store']);
    Route::put('/salary/update/{id}', [SalaryController::class, 'update']);
    Route::delete('/salary/delete/{id}', [SalaryController::class, 'destroy']);

    // sms
    Route::get('/smses', [SmsController::class, 'index']);
    Route::post('sms/send', [SmsController::class, 'store']);
    Route::delete('/sms/delete/{id}', [SmsController::class, 'destroy']);
    Route::get('/homedata', [SmsController::class, 'homeData']);
});
