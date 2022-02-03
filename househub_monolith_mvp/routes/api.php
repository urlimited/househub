<?php

use App\Http\Controllers\RealEstateController;
use App\Http\Controllers\RegisterController;
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

});

Route::get('/users', [RegisterController::class, 'getUsers']);

Route::group(['prefix' => 'auth'],function(){
    Route::post('/register', [RegisterController::class, 'registerResidentUser']);
    Route::post('/auth-code', [RegisterController::class, 'sendConfirmationPhoneCall']);
    Route::post('/auth-code-confirmation', [RegisterController::class, 'confirmPhoneAuthCode']);
});


Route::group(['prefix' => 'real-estates'],function() {
    Route::get('/apartments', [RealEstateController::class, 'getApartments']);
    Route::post('/apartments', [RealEstateController::class, 'createApartment']);
    Route::post('/apartments/{id}', [RealEstateController::class, 'updateApartment']);
    Route::delete('/apartments/{id}', [RealEstateController::class, 'deleteApartment']);

    Route::get('/houses', [RealEstateController::class, 'getHouses']);
    Route::post('/houses', [RealEstateController::class, 'createHouse']);
    Route::post('/houses/{id}', [RealEstateController::class, 'updateHouse']);
    Route::delete('/houses/{id}', [RealEstateController::class, 'deleteHouse']);

    Route::get('/residential-complexes', [RealEstateController::class, 'getResidentialComplexes']);
    Route::post('/residential-complexes', [RealEstateController::class, 'createResidentialComplex']);
    Route::post('/residential-complexes/{id}', [RealEstateController::class, 'updateResidentialComplex']);
    Route::delete('/residential-complexes/{id}', [RealEstateController::class, 'deleteResidentialComplex']);
});

Route::get('/cities', [RealEstateController::class, 'getCities']);
Route::get('/management-companies', [RealEstateController::class, 'getManagementCompanies']);
