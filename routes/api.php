<?php
/** 
 * Venezuela, Enero 2023
 * Realizado por 
 * @author Tarsicio Carrizales <telecom.com.ve@gmail.com>
 * @copyright 2023 Tarsicio Carrizales
 * @version 1.0.0
 * @since 2023-01-01
 * @license MIT
*/
use App\Http\Controllers\NotificarController;
use App\Models\User\User;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\UserController;
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
| ->middleware(['auth:sanctum', 'abilities:check-status,place-orders'])
| ->middleware(['auth:sanctum', 'ability:check-status,place-orders'])
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', [UserController::class, 'login'])->name('login.login');
    Route::group(['middleware'=> ['auth:sanctum']], function(){
        Route::post('/logout', [UserController::class, 'logout'])->name('logout.logout');    
    });
    
    Route::post('/register', [RegisterController::class, 'create'])->name('register.create');    
    Route::post('/register/confirm/{confirmation_code}', [RegisterController::class, 'confirm'])->name('register.confirm');
    Route::post('/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('reset.sendResetLinkEmail');
    Route::post('/password/reset', [App\Http\Controllers\Auth\resetPasswordController::class, 'reset'])->name('password.reset');
});
