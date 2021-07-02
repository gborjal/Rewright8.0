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

	


Route::middleware(['web'])->group(function () {
	Route::get('/', [indexController::class,'index']);
	
	// Route::prefix('auth')->group(function () {	
	// 	//Login route
	Route::get('login',[AuthController::class,'showLoginForm'])->name('login');
	Route::post('login', [AuthController::class,'login']);
	Route::get('logout',[userController::class,'getLogout'])->name('logout');	
	// 	//Admin Login Route
		Route::post('admin/login', [AuthController::class,'loginAdmin'])->name('loginAdmin');
		Route::get('admin/login',[AuthController::class,'showAdminLoginForm'])->name('showAdminLoginForm');

		Route::get('admin/logout',[userController::class,'getLogoutAdmin'])->name('logoutAdmin');
	 	
	 	//Route::get('logout',[userController::class,'getLogoutAdmin'])->name('logoutAdmin');
	// });

	//Route::get('/dashboard', [userController::class,'dashboard']);
	Route::get('/dashboard', [userController::class,'dashboard'])->name('dashboard');
	Route::get('/dashboard', [userController::class,'dashboard'])->name('dashboard');
	Route::get('admin/dashboard', [userController::class,'dashboardAdmin'])->name('dashboardAdmin');
	Route::prefix('auth')->group(function () {;
		//Profile routes
		Route::prefix('profile')->group(function () {
			Route::get('edit/{code}',[userController::class,'editUserProfile1']);
			//Route::post('edit/{code}', [userController::class,'editUserProfile1'])->name('editProfile');
		});
	});
	Route::get('/preview/{id}', [taskController::class,'reviewExercise']);
	Route::prefix('/recordings')->group(function () {
		Route::get('lab', [taskController::class,'vanillaLab'])->name('vanillaLab');

		Route::get('exer/{id}', [taskController::class,'getExerDataTask']);	//ajax request\
		Route::get('patient_exer/{id}', [taskController::class,'getPatientExerDataTask']);	//ajax request\
		Route::get('training/{id}', [taskController::class,'getTrainingDataTask']);	//ajax request\
		Route::get('preview/{id}', [taskController::class,'getExerData']);
	});
	Route::get('/tasks/{id}', [taskController::class,'openTask']);
	Route::prefix('/profile')->group(function () {
		Route::get('image/{type}/{person}', [imagesController::class,'profilePicture']);
		Route::get('image/get/{type}/{image}', [imagesController::class,'forcedGetPicture']);
	});
	Route::get('/discussion/image/{image}', [imagesController::class,'discussionImage']);	//possible change
});
Route::middleware(['Auth:api'])->group(function () {
	Route::post('/tasks/info', [taskController::class,'getTask'])->name('taskBoardInfo');	//ajax request
		//Route::get('info', [taskController::class,'getTask']);
	Route::post('/list/task', [notesController::class,'getTaskExerDataNotes'])->name('noteListTask');	//ajax request
			//Route::get('/list/task', [notesController::class,'getTaskExerDataNotes']);
});
?>