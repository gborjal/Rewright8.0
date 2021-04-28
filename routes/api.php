<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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
	
	Route::post('note', [notesController::class,'postNote'])->name('postNote');	//ajax 
	//Route::get('note', [notesController::class,'postNote']);
	
});