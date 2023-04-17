<?php

use App\Api\V1\Controllers\AppearanceController;
use App\Api\V1\Controllers\BannerController;
use App\Api\V1\Controllers\CategoryController;
use App\Api\V1\Controllers\CommentController;
use App\Api\V1\Controllers\ContactController;
use App\Api\V1\Controllers\InquiryController;
use App\Api\V1\Controllers\ProductController;
use App\Api\V1\Controllers\SliderController;
use App\Api\V1\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API router for your application. These
| router are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/appearance',AppearanceController::class);

Route::group(['prefix'=>'product'],function (){
    Route::get('/searchHelpers',[ProductController::class,'giveSearchHelpers']);
    Route::get('/front_page',[ProductController::class,'getFrontPageProducts']);
    Route::get('/{product}',[ProductController::class,'show']);
    Route::post('/search',[ProductController::class,'search']);
});


Route::prefix('category')->group(function (){
    Route::get('/presentable',CategoryController::class);
});
Route::group(['prefix'=>'slider'],function (){
    Route::get('',SliderController::class);
});
Route::get('/banners',BannerController::class);

Route::post('/comment/{product}',CommentController::class);

Route::group(['prefix'=>'inquiry'],function (){
    Route::get('/hot_keys',[InquiryController::class,'getHotKeys']);
    Route::post('/{product}',InquiryController::class);
});

Route::get('/contact',ContactController::class);
Route::post('/subscribe',SubscriberController::class);

