<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\indexController;
use App\Http\Controllers\Auth\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [indexController::class,'index']);
Route::prefix('auth')->group(function () {	//login routes
	Route::get('login',[AuthController::class,'showLoginForm']);
	Route::post('login', [AuthController::class,'login'])->name('login');
	
	Route::prefix('admin')->group(function () {
		Route::get('login',[AuthController::class,'showAdminLoginForm']);
		Route::post('login', [AuthController::class,'loginAdmin'])->name('loginAdmin');
	});
});
