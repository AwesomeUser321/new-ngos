<?php

use App\Http\Controllers\BasicInformationController;

use App\Http\Controllers\FinancialDetailController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OperationController;
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
Route::get('/cities', [BasicInformationController::class, 'getCities']);

//Route::get('/basic-information/{id}', [BasicInformationController::class, 'basicget'])->name('basic-information.view');
//Route::get('/basic-information/{id}/edit', [BasicInformationController::class, 'basicget'])->name('basic-information.edit');
Route::put('/basic/{id}', [BasicInformationController::class, 'update']);


//membership
Route::get('/members/{id}/view', [BasicInformationController::class, 'view'])->name('members.view');
Route::get('/members/{id}/edit', [BasicInformationController::class, 'edit'])->name('members.edit');
Route::get('/members', [BasicInformationController::class, 'showMembers']);

//showExecutiveBody
Route::get('/excutive-body', [MemberController::class, 'showExecutiveBody'])->name('showExecutiveBody.show');
Route::get('/general-body', [MemberController::class, 'showGeneralBody'])->name('showGeneralBody.show');
//end all membership

//financial details
Route::middleware('api')->group(function () {
    Route::post('/financial-detail', [FinancialDetailController::class, 'store']);
    Route::get('/financial-details', [FinancialDetailController::class, 'index']);
    Route::put('/financial-detail/{id}', [FinancialDetailController::class, 'update']);
    Route::delete('/financial-detail/{id}', [FinancialDetailController::class, 'destroy']);
    Route::get('banks', [FinancialDetailController::class, 'getbank']);
    Route::get('proposed-finances', [FinancialDetailController::class, 'ProposedFinanceget']);
//end financial details

});

//area of operation
Route::get('/operations', [OperationController::class, 'index']);
Route::post('/operations', [OperationController::class, 'store']);
Route::put('/operations/{id}', [OperationController::class, 'update']);
Route::delete('/operations/{id}', [OperationController::class, 'destroy']);






