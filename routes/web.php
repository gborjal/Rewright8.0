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

Route::group(['middleware' => 'web'], function () {

    Route::auth();

    Route::get('/', 'HomeController@index');

    // Moving here will ensure that sessions, csrf, etc. is included in all these routes
    Route::group(['prefix'=>'admin',  'middleware' => 'admin'], function(){
        Route::get('/', function(){
            return view('admin.index');
        });

        Route::get('/user', function(){
            return view('admin.user');
        });
    });
});
?>