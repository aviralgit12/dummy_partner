<?php
use Illuminate\Http\Request;
use App\Http\Controllers\PartnerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('login');
});

Route::post('/store-token',[PartnerController::class,'storeToken']);
Route::get('/logout',[PartnerController::class,'logoutSession']);
Route::get('/transaction',[PartnerController::class,'transaction']);
Route::get('/all-users',[PartnerController::class,'getAllUsers']);

Route::get('/',[PartnerController::class,'login']);
// uploadPetPoints
Route::get('/uploadPetPoints',[PartnerController::class,'uploadPetPoints']);

