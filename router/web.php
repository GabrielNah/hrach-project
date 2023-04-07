<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CurrencyRateController;
use App\Http\Controllers\Admin\ProductAdditionalController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductFileController;
use App\Http\Controllers\Admin\ProductMainInfoConroller;
use App\Http\Controllers\Admin\ProductPriceController;
use App\Http\Controllers\Admin\ProductTagablesController;
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
            Route::group(['prefix'=>'currency_rates'],function (){
                Route::get('',[CurrencyRateController::class,'index']);
                Route::post('',[CurrencyRateController::class,'store']);
            });
        });


        Route::group(['prefix'=>'product'],function (){
            Route::get('',[ProductController::class,'create']);
            Route::get('all',[ProductController::class,'index']);
            Route::post('/store',[ProductController::class,'store']);
            Route::get('/edit/{product}',[ProductController::class,'show']);
            Route::delete('/{product}',[ProductController::class,'destroy']);

            Route::scopeBindings()->prefix('files')->group(function (){
               Route::get('{product}',[ProductFileController::class,'index']);
               Route::put('{product}/upload',[ProductFileController::class,'uploadOne']);
               Route::patch('{product}/multiupload',[ProductFileController::class,'uploadMany']);
               Route::post('/general/{product}/{file}',[ProductFileController::class,'markGeneral']);
               Route::delete('{product}/{file}',[ProductFileController::class,'destroy']);
            });

            Route::scopeBindings()->prefix('prices')->group(function (){
               Route::get('{product}',[ProductPriceController::class,'index']);
               Route::post('{product}',[ProductPriceController::class,'upsert']);
               Route::delete('{product}/{price}',[ProductPriceController::class,'destroy']);
            });
            Route::group(['prefix'=>'additional'],function (){
                Route::get('{product}',[ProductAdditionalController::class,'index']);
                Route::post('{product}',[ProductAdditionalController::class,'edit']);
            });
            Route::group(['prefix'=>'main'],function (){
                Route::get('{product}',[ProductMainInfoConroller::class,'index']);
                Route::post('{product}',[ProductMainInfoConroller::class,'edit']);
            });
            Route::group(['prefix'=>'tagables'],function (){
                Route::get('{product}',[ProductTagablesController::class,'index']);
                Route::post('tags/{product}',[ProductTagablesController::class,'editTags']);

                Route::group(['prefix'=>'sizes'],function(){
                    Route::post('general/{product}',[ProductTagablesController::class,'editGeneralSizes']);
                    Route::delete('individual/{product}/{size}',[ProductTagablesController::class,'destroySize']);
                    Route::post('individual/{product}/{size?}',[ProductTagablesController::class,'upsert']);
                });
                Route::group(['prefix'=>'colors'],function(){
                    Route::post('general/{product}',[ProductTagablesController::class,'editGeneralColors']);
                    Route::delete('individual/{product}/{color}',[ProductTagablesController::class,'deleteIndividualColor']);
                    Route::post('individual/{product}/{color?}',[ProductTagablesController::class,'upsertColors']);
                });
            });
        });

        Route::group(['prefix'=>'comment'],function (){
            Route::get('/{product}',[CommentController::class,'index']);
            Route::post('/{product}',[CommentController::class,'store']);
            Route::put('/{comment}',[CommentController::class,'edit']);
            Route::delete('/{comment}',[CommentController::class,'destroy']);
        });
    });

});
Route::view('/{any?}','welcome')->where('any','.*');
