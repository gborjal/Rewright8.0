<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\adminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\discussionController;
use App\Http\Controllers\taskController;
use App\Http\Controllers\imagesController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\notesController;
use App\Http\Controllers\projectsController;
use App\Http\Controllers\userController;
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
Route::middleware(['web', 'auth'])->group(function () {

    Route::get('/', [indexController::class,'index']);
    Route::prefix('auth')->group(function () {	
		//Login routes
		Route::get('login',[AuthController::class,'showLoginForm']);
		Route::post('login', [AuthController::class,'login'])->name('login');

		Route::get('logout',[userController::class,'getLogout'])->name('logout');

		Route::prefix('admin')->group(function () {
			//Admin Login Routes
			Route::get('login',[AuthController::class,'showAdminLoginForm']);
			Route::post('login', [AuthController::class,'loginAdmin'])->name('loginAdmin');
			
			Route::get('logout',[userController::class,'getLogoutAdmin'])->name('logoutAdmin');
		});
		//Profile routes
		Route::prefix('profile')->group(function () {
			Route::post('save', [userController::class,'saveEditUserProfile'])->name('postEditProfile');	//ajax request
			Route::get('edit/{code}',[userController::class,'editUserProfile1']);
			Route::post('edit/{code}', [userController::class,'editUserProfile1'])->name('editProfile');
		});
		//Specialist search
		Route::prefix('search')->group(function () {
			//Route::get('auth/search/patient', 'userController@getPatientSrch');
			Route::post('patient', [userController::class,'getPatientSrch'])->name('getPatientSrch');
		});
	});
});

?>