<?php

use App\Http\Controllers\PartnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});
Route::get('/api/createCsrfToken',[PartnerController::class,'createCsrfToken']);
Route::post('/api/uploadUserPetPoints',[PartnerController::class,'uploadUserPetPoints']);
Route::get('/create-user',function () {
    return view('createUser');
});

Route::get('/all-users',function () {
    return view('allUsers');
});