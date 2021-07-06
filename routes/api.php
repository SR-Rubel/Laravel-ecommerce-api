<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\CategoryController;

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

Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('forgot-password',[ForgotController::class,'forgotPassword']);
Route::post('reset-password',[ForgotController::class,'resetPassword']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('profile',[UserController::class,'profile']);
    Route::get('logout',[UserController::class,'logout']);
});

Route::group(['prefix'=>'admin','middleware'=>['auth:api','admin']],function () {
    Route::get('/dashboard',function(){
        return "hello admin";
        // return Auth::user()->isadmin;
    });
    Route::get('/user-list',[AdminController::class,'allUser']);
    Route::post('/add-category',[CategoryController::class,'store']);
    Route::get('/list-category',[CategoryController::class,'index']);
    Route::delete('/delete-category/{id}',[CategoryController::class,'delete']);
    Route::patch('/edit-category/{id}',[CategoryController::class,'edit']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
