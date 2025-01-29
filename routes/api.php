<?php

use App\Http\Controllers\PartnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/uploadUserPetPoints',[PartnerController::class,'uploadUserPetPoints']);
    // getCustomer
    Route::get('/getCustomer/{id}',[PartnerController::class,'getCustomer']);
    Route::get('/getAllCustomer',[PartnerController::class,'getAllCustomer']);
    // getAllTransaction
    Route::get('/getAllTransaction',[PartnerController::class,'getAllTransaction']);

    // loginUser
   
    // editCustomer
    
    Route::post('/editCustomer/{id}',[PartnerController::class,'editCustomer']);
    // referralLink
    
   
    Route::post('/createCustomer',[PartnerController::class,'createCustomer']);
    // uploadSandBox
    Route::post('/uploadSandBox',[PartnerController::class,'uploadSandBox']);
    Route::get('/getUploadSandBox',[PartnerController::class,'getUploadSandBox']);

});
// checkCustomerPetPoints
Route::get('/checkCustomerPetPoints/{id}/{amount}',[PartnerController::class,'checkCustomerPetPoints']);
// customerUsedPetPoints
Route::post('/customerUsedPetPoints',[PartnerController::class,'customerUsedPetPoints']);

Route::get('/referralLink/{uuid}',[PartnerController::class,'referralLink']);
Route::post('/login',[PartnerController::class,'loginUser']);