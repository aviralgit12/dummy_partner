<?php

use App\Http\Controllers\PartnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api/createCsrfToken',[PartnerController::class,'createCsrfToken']);
Route::post('/api/uploadUserPetPoints',[PartnerController::class,'uploadUserPetPoints']);