<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web router for your application. These
| router are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix'=>'admin'],function (){
    Route::post('/login',[AdminAuthController::class,'login']);
    Route::group(['middleware'=>'auth:admin'],function (){

        Route::post('/logout',[AdminAuthController::class,'logout']);
        Route::get('/me',[AdminAuthController::class,'getAdmin']);


        Route::group(['prefix'=>'category'],function (){
            Route::get('',[CategoryController::class,'index']);
            Route::post('store/{category?}',[CategoryController::class,'store']);
            Route::delete('/{category}',[CategoryController::class,'delete']);
        });


    });

});
Route::view('/{any?}','welcome')->where('any','.*');
