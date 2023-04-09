<?php

use App\Api\V1\Controllers\ProductController;
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


Route::group(['prefix'=>'product'],function (){
    Route::get('/{product}',[ProductController::class,'show']);
});
Route::group(['prefix'=>'slider'],function (){
    Route::get('',\App\Api\V1\Controllers\SliderController::class);
});
Route::get('/banners',\App\Api\V1\Controllers\BannerController::class);

Route::post('/comment/{product}',\App\Api\V1\Controllers\CommentController::class);
