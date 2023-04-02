<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductFileController;
use App\Http\Controllers\Admin\SettingController;
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
    Route::group(['middleware'=>['auth:admin','is_admin'],],function (){

        Route::post('/logout',[AdminAuthController::class,'logout']);
        Route::get('/me',[AdminAuthController::class,'getAdmin']);


        Route::group(['prefix'=>'category'],function (){
            Route::get('',[CategoryController::class,'index']);
            Route::post('store/{category?}',[CategoryController::class,'store']);
            Route::delete('/{category}',[CategoryController::class,'delete']);
        });

        Route::group(['prefix'=>'settings'],function (){
            Route::get('/all',[SettingController::class,'getSettings']);
            Route::group(['prefix'=>'color'],function (){
                Route::post('',[SettingController::class,'storeColor']);
                Route::put('/{id}',[SettingController::class,'editColor']);
                Route::delete('/{id}',[SettingController::class,'deleteColor']);
            });

            Route::group(['prefix'=>'size'],function (){
                Route::post('',[SettingController::class,'storeSize']);
                Route::put('/{id}',[SettingController::class,'editSize']);
                Route::delete('/{id}',[SettingController::class,'removeSize']);
            });

            Route::group(['prefix'=>'tag'],function (){
                Route::post('',[SettingController::class,'createTag']);
                Route::put('/{tag}',[SettingController::class,'editTag']);
                Route::delete('/{id}',[SettingController::class,'removeTag']);
            });
        });


        Route::group(['prefix'=>'product'],function (){
            Route::get('',[ProductController::class,'create']);
            Route::post('/store',[ProductController::class,'store']);
            Route::get('/edit/{product}',[ProductController::class,'show']);

            Route::scopeBindings()->prefix('files')->group(function (){
               Route::get('{product}',[ProductFileController::class,'index']);
               Route::put('{product}/upload',[ProductFileController::class,'uploadOne']);
               Route::delete('{product}/{file}',[ProductFileController::class,'destroy']);
            });
        });
    });

});
Route::view('/{any?}','welcome')->where('any','.*');
