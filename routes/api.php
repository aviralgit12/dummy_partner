<?php

use App\Http\Controllers\PartnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/uploadUserPetPoints',[PartnerController::class,'uploadUserPetPoints']);
// getCustomer
Route::post('/getCustomer/{id}',[PartnerController::class,'getCustomer']);
