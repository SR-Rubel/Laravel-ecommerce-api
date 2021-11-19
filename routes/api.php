<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ForgotController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\SubCategoryController;
use App\Http\Controllers\api\WishlistController;
use App\Models\Wishlist;

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


// ----------auth routes-------------------------
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::post('forgot-password',[ForgotController::class,'forgotPassword']);
Route::post('reset-password',[ForgotController::class,'resetPassword']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('profile',[UserController::class,'profile'])->name('profile');
    Route::get('logout',[UserController::class,'logout']);
});


//==================admin routes===================
Route::group(['prefix'=>'admin','middleware'=>[]],function () {
    Route::get('/dashboard',function(){
        return "hello admin";
        // return Auth::user()->isadmin;
    });
    Route::get('/user-list',[AdminController::class,'allUser']);

    //category route
    Route::post('/add-category',[CategoryController::class,'create']);
    Route::delete('/delete-category/{id}',[CategoryController::class,'delete']);
    Route::post('/edit-category/{id}',[CategoryController::class,'update']);

    //subcategory route
    Route::post('/add-sub-category',[SubCategoryController::class,'create']);
    Route::delete('/delete-subcategory/{id}',[SubCategoryController::class,'delete']);
    Route::post('/edit-subcategory/{id}',[SubCategoryController::class,'update']);

    //brand
    Route::post('/add-brand',[BrandController::class,'create']);
    Route::delete('/delete-brand/{id}',[BrandController::class,'delete']);
    Route::post('/edit-brand/{id}',[BrandController::class,'update']);

    //product
    Route::post('/add-product',[ProductController::class,'create']);
    Route::post('/edit-product/{id}',[ProductController::class,'update']);
    Route::delete('/delete-product/{id}',[ProductController::class,'delete']);
});

// ====================common routes=====================

    //category route
    Route::get('/list-category',[CategoryController::class,'index']);

    //subcategory route
    Route::get('/list-subcategories',[SubCategoryController::class,'index']);
    Route::get('/category/{id}/subcategories',[SubCategoryController::class,'cat_wise_subcat']);

    //brand
    Route::get('/brand-list',[BrandController::class,'index']);
    Route::get('/brand/{id}/categories',[BrandController::class,'brandCategory']);

    // products
    Route::get('/all-product',[ProductController::class,'index']);
    Route::get('/category/{id}/products',[ProductController::class,'cat_wise_products']);
    Route::get('/sub-category/{id}/products',[ProductController::class,'subCat_wise_products']);
    Route::get('/brand/{id}/products',[ProductController::class,'brand_wise_products']);

    //cart
    Route::apiResource('/carts',CartController::class,["only"=>["store","show"]]);
    Route::delete('carts/{user_id}/product/{product_id}',[CartController::class,'delete_product_from_cart']);
    Route::delete('carts/empty/{user_id}',[CartController::class,'delete_cart']);

    //wsihlist
    Route::apiResource('/wishlists',WishlistController::class,["only"=>["store","show"]]);
    Route::delete('wishlists/{user_id}/product/{product_id}',[WishlistController::class,'delete_product_from_wishlist']);
    Route::delete('wishlists/empty/{user_id}',[WishlistController::class,'delete_wishlist']);
    //order
    Route::apiResource('/orders',OrderController::class);



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
