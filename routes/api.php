<?php

use App\Http\Controllers\BasicInformationController;
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


Route::post('basic-information', [BasicInformationController::class, 'store']);

Route::get('aim-objectives', [BasicInformationController::class, 'index']);

Route::post('members', [BasicInformationController::class, 'store_member']);

Route::get('details', [BasicInformationController::class, 'show']);





