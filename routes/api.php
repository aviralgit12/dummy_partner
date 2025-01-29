<?php

use App\Http\Controllers\PartnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/uploadUserPetPoints',[PartnerController::class,'uploadUserPetPoints']);
// getCustomer
Route::get('/getCustomer/{id}',[PartnerController::class,'getCustomer']);
Route::get('/getAllCustomer',[PartnerController::class,'getAllCustomer']);
// loginUser
Route::post('/login',[PartnerController::class,'loginUser']);
// editCustomer

Route::post('/editCustomer/{id}',[PartnerController::class,'editCustomer']);
// referralLink

Route::get('/referralLink/{uuid}',[PartnerController::class,'referralLink']);
Route::post('/createCustomer',[PartnerController::class,'createCustomer']);