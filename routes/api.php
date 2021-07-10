<?php

use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ForgotController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;

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

Route::group(['prefix'=>'admin','middleware'=>[]],function () {
    Route::get('/dashboard',function(){
        return "hello admin";
        // return Auth::user()->isadmin;
    });
    Route::get('/user-list',[AdminController::class,'allUser']);

    //category route
    Route::post('/add-category',[CategoryController::class,'create']);
    Route::get('/list-category',[CategoryController::class,'index']);
    Route::delete('/delete-category/{id}',[CategoryController::class,'delete']);
    Route::post('/edit-category/{id}',[CategoryController::class,'update']);

    //subcategory route
    Route::post('/add-sub-category',[SubCategoryController::class,'create']);
    Route::get('/category/{id}/subcategories',[SubCategoryController::class,'index']);
    Route::delete('/delete-subcategory/{id}',[SubCategoryController::class,'delete']);
    Route::post('/edit-subcategory/{id}',[SubCategoryController::class,'update']);

    //brand
    Route::get('/brand-list',[BrandController::class,'index']);
    Route::get('/brand/{id}/categories',[BrandController::class,'brandCategory']);
    Route::post('/add-brand',[BrandController::class,'create']);
    Route::delete('/delete-brand/{id}',[BrandController::class,'delete']);
    Route::post('/edit-brand/{id}',[BrandController::class,'update']);

    //product
    Route::get('/all-product',[ProductController::class,'index']);
    Route::post('/add-product',[ProductController::class,'create']);
    Route::post('/edit-product/{id}',[ProductController::class,'update']);
    Route::delete('/delete-product/{id}',[ProductController::class,'delete']);


    
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
