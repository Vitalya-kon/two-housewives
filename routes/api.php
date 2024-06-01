<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceCleaningController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\FormServiceController;
use App\Http\Controllers\CustomAuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('service_cleaning', ServiceCleaningController::class);
Route::resource('galleries', GalleryController::class);

Route::post('/submit-form', [FormServiceController::class, 'submitForm']);



Route::get('auth-check', [CustomAuthController::class, 'authCheck'])->name('authCheck');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('register', [CustomAuthController::class, 'registration'])->name('register');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [CustomAuthController::class, 'user']);
    Route::get('logout', [CustomAuthController::class, 'logout']);
});
