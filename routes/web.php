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
Route::prefix('admin')->group(function () {
	Route::get('dashboard', [userController::class,'dashboardAdmin'])->name('dashboardAdmin');
	//Admin functionality Routes
	Route::post('register', [adminController::class,'registerByAdmin'])->name('registerByAdmin');
	Route::get('register', [adminController::class,'registerByAdmin']);

	Route::post('getCode', [adminController::class,'getActivationCode'])->name('getActivationCode');
	Route::get('getCode', [adminController::class,'getActivationCode']);

	Route::post('patientGroupInfo', [adminController::class,'getPatientGroup'])->name('getPatientGroup');
	Route::get('patientGroupInfo', [adminController::class,'getPatientGroup']);

	Route::post('updatepgcount', [adminController::class,'postUpdatePGCount'])->name('pgUpdateCount');	//ajax request
	//Route::get('updatepgcount', [adminController::class,'postUpdatePGCount']);
});
Route::get('/dashboard', [userController::class,'dashboard'])->name('dashboard');
Route::get('/dashboard2', [userController::class,'dashboard2'])->name('dashboard2');

Route::prefix('/discussion')->group(function () {
	Route::post('/', [discussionController::class,'getDiscussion'])->name('discussion');	//ajax request
	//Route::get('/', [discussionController::class,'getDiscussion']);
	Route::post('board', [discussionController::class,'getDiscussions'])->name('discussionBoard');	//ajax request
	//Route::get('board', [discussionController::class,'getDiscussions']);
	Route::post('comments', [discussionController::class,'getComments'])->name('discComments');	//ajax request
	Route::get('comments/{$id}', [discussionController::class,'getComments']);
	Route::post('upvotes', [discussionController::class,'postUpvotes'])->name('discUpvotes');	//ajax request
	//Route::get('upvotes', [discussionController::class,'postUpvotes']);
	Route::get('image/{image}', [imagesController::class,'discussionImage']);	//possible change
});
Route::prefix('/tasks')->group(function () {

	Route::get('{id}', [taskController::class,'openTask']);				//ajax request
	Route::get('/', [taskController::class,'openTasks']);
	Route::post('board', [taskController::class,'getTasks'])->name('taskBoard');	//ajax request
	//Route::get('board', [taskController::class,'getTasks']);
	Route::post('info', [taskController::class,'getTask'])->name('taskBoardInfo');	//ajax request
	//Route::get('info', [taskController::class,'getTask']);

});
//Route::middleware(['web', 'cors'])->group(function () {
	Route::prefix('/post')->group(function () {
		Route::prefix('discussion')->group(function () {
			Route::post('thread', [discussionController::class,'postDiscussion'])->name('postDiscussion');	//ajax request
			//Route::get('thread', [discussionController::class,'postDiscussion']);
			Route::post('comment', [discussionController::class,'postDiscussionComment'])->name('postDiscussionComment');	//ajax request
			//Route::get('comment', [discussionController::class,'postDiscussionComment']);
			Route::post('comment/cnt', [discussionController::class,'postDiscussionCommentCnt'])->name('postDiscussionCommentCnt');	//ajax request
			//Route::get('comment/cnt', [discussionController::class,'postDiscussionCommentCnt']);
			Route::post('notifs/cnt', [discussionController::class,'postDiscussionNotifsCnt'])->name('postDiscussionNotifsCnt');	//ajax request
			//Route::get('notifs/cnt', [discussionController::class,'postDiscussionNotifsCnt']);
		});
		Route::prefix('task')->group(function () {
			Route::post('item', [taskController::class,'postTask'])->name('postTask');	//ajax 
			//Route::get('item', [taskController::class,'postTask']);
			Route::post('patient', [taskController::class,'postTaskPatient'])->name('postTaskPatient');	//ajax 
			//Route::get('patient', [taskController::class,'postTaskPatient']);
			Route::post('patient/result', [taskController::class,'postTaskPatientResult'])->name('postTaskPatientResult');	//ajax 
			Route::get('patient/result', [taskController::class,'postTaskPatientResult']);
		});
		Route::prefix('exerdata')->group(function () {
			Route::post('/', [taskController::class,'postExerciseData'])->name('postExerciseData');	//ajax 
			//Route::get('/', [taskController::class,'postExerciseData']);
			Route::post('list', [taskController::class,'postExerciseDataList'])->name('postExerciseDataList');	//ajax 
			//Route::get('list', [taskController::class,'postExerciseDataList']);
			Route::post('adjustedScore', [taskController::class,'postAdjustedScore'])->name('postAdjustedScore');	//ajax 
			Route::get('adjustedScore', [taskController::class,'postAdjustedScore']);
		});
		Route::group(['prefix'=>'patient',  'middleware' => ['web','admin'], function(){
			Route::auth();
			Route::post('list', [projectsController::class,'postPatientDataList'])->name('postExerciseDataList');	//ajax 
			Route::get('list', [projectsController::class,'postPatientDataList']);
		});
		/*Route::prefix('patient')->group(function () {
			Route::post('list', [projectsController::class,'postPatientDataList'])->name('postExerciseDataList');	//ajax 
			Route::get('list', [projectsController::class,'postPatientDataList']);
		});*/
		Route::post('note', [notesController::class,'postNote'])->name('postNote');	//ajax 
		//Route::get('note', [notesController::class,'postNote']);
		
		
	});
//});
Route::prefix('/profile')->group(function () {
	Route::get('image/{type}/{person}', [imagesController::class,'profilePicture']);
	Route::get('image/get/{type}/{image}', [imagesController::class,'forcedGetPicture']);
});
Route::prefix('/project')->group(function () {
	Route::post('getProjects', [projectsController::class,'getProjects'])->name('getProjects');	//ajax request
	//Route::get('getProjects', [projectsController::class,'getProjects']);	//ajax request

	Route::post('joinProject/{id}', [projectsController::class,'joinProject'])->name('joinProject');	//ajax request
	//Route::get('joinProject/{id}', [projectsController::class,'joinProject']);	
});
Route::get('/preview/{id}', [taskController::class,'reviewExercise']);				//ajax request
Route::prefix('/recordings')->group(function () {
	Route::post('lab', [taskController::class,'vanillaLab'])->name('vanillaLab');	//ajax 
	Route::get('lab', [taskController::class,'vanillaLab']);				
	Route::post('exer/result/', [taskController::class,'getResultData']);	//ajax request\
	Route::get('exer/{id}', [taskController::class,'getExerDataTask']);	//ajax request\
	Route::get('patient_exer/{id}', [taskController::class,'getPatientExerDataTask']);	//ajax request\
	Route::get('training/{id}', [taskController::class,'getTrainingDataTask']);	//ajax request\
	Route::get('preview/{id}', [taskController::class,'getExerData']);	//ajax request\
});

Route::prefix('/note')->group(function () {
	Route::post('/', [notesController::class,'getNotegetNote'])->name('noteInfo');	//ajax request
	//Route::get('/', [notesController::class,'getNotegetNote']);
	Route::prefix('/list')->group(function () {
		Route::post('/', [notesController::class,'getPatientNotes'])->name('noteList');	//ajax request
		//Route::get('/', [notesController::class,'getPatientNotes']);
		Route::post('task', [notesController::class,'getTaskExerDataNotes'])->name('noteListTask');	//ajax request
		Route::get('task', [notesController::class,'getTaskExerDataNotes']);
	});
		

});
?>