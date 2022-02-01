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

Route::post('/auth/register', [RegisterController::class, 'registerResidentUser']);

Route::post('/auth/auth_code', [RegisterController::class, 'sendConfirmationPhoneCall']);
Route::post('/auth/auth_code_confirmation', [RegisterController::class, 'confirmPhoneAuthCode']);

Route::post('/real_estates/apartment', [RealEstateController::class, 'createApartment']);
Route::post('/real_estates/house', [RealEstateController::class, 'createHouse']);
Route::post('/real_estates/residential_complex', [RealEstateController::class, 'createResidentialComplex']);

// New REST conventions
Route::post('/auth/companies/register', [RegisterController::class, 'registerCompany']);
Route::post('/auth/users/register', [RegisterController::class, 'registerUser']);
