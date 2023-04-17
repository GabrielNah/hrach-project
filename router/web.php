<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactInfoController;
use App\Http\Controllers\Admin\CurrencyRateController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\InquiryHotKeyController;
use App\Http\Controllers\Admin\ProductAdditionalController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductFileController;
use App\Http\Controllers\Admin\ProductMainInfoConroller;
use App\Http\Controllers\Admin\ProductPriceController;
use App\Http\Controllers\Admin\ProductTagablesController;
use App\Http\Controllers\Admin\ProjectStateController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SubscriberController;
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
        Route::post('/change',[AdminAuthController::class,'changeCredentials']);

        Route::group(['prefix'=>'state'],function (){
            Route::get('/inquiry',[ProjectStateController::class,'unreadInquiryExists']);
            Route::get('/all',[ProjectStateController::class,'projectState']);
            Route::get('/appearance',[ProjectStateController::class,'siteAppearance']);
            Route::post('/edit/appearance/{id}',[ProjectStateController::class,'editAppearance']);
        });


        Route::group(['prefix'=>'category'],function (){
            Route::get('',[CategoryController::class,'index']);
            Route::post('store/{category?}',[CategoryController::class,'store']);
            Route::put('showable',[CategoryController::class,'makeCategoriesShowable']);
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

            Route::apiResource('home',\App\Http\Controllers\Admin\HomePageSettingsController::class);
        });


        Route::group(['prefix'=>'product'],function (){
            Route::get('',[ProductController::class,'create']);
            Route::get('all',[ProductController::class,'index']);
            Route::post('/store',[ProductController::class,'store']);
            Route::post('/search',[ProductController::class,'search']);
            Route::post('/exact',[ProductController::class,'getExactProducts']);
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
               Route::post('/store/{product}',[ProductPriceController::class,'store']);
               Route::put('/{product}/edit/{price}',[ProductPriceController::class,'edit']);
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

        Route::prefix('slider')->group(function (){
            Route::get('index',[SliderController::class,'index']);
            Route::get('initial',[SliderController::class,'getInitialDataForSearchHelp']);
            Route::post('store',[SliderController::class,'store']);
            Route::put('/{slider}/edit',[SliderController::class,'edit']);
            Route::delete('/{slider}',[SliderController::class,'destroy']);
        });

        Route::apiResource('banners',BannerController::class);

        Route::group(['prefix'=>'hot_keys'],function (){
            Route::get('',[InquiryHotKeyController::class,'index']);
            Route::post('/store',[InquiryHotKeyController::class,'store']);
            Route::put('/edit/{id}',[InquiryHotKeyController::class,'edit']);
            Route::delete('/{id}',[InquiryHotKeyController::class,'destroy']);
        });

        Route::group(['prefix'=>'contactInfo'],function (){
            Route::get('/',[ContactInfoController::class,'get']);
            Route::post('/store',[ContactInfoController::class,'store']);
            Route::group(['prefix'=>'social'],function (){
                Route::get('/',[ContactInfoController::class,'getSocialMedia']);
                Route::post('/store',[ContactInfoController::class,'storeSocialMedia']);
                Route::put('/edit/{id}',[ContactInfoController::class,'editSocialMedia']);
                Route::delete('/{id}',[ContactInfoController::class,'destroy']);
            });

        });

        Route::get('/subscribers',SubscriberController::class);

        Route::group(['prefix'=>'inquiry'],function (){
            Route::get('',[InquiryController::class,'index']);
            Route::put('/{id}',[InquiryController::class,'read']);
        });
    });

});
Route::view('/{any?}','welcome')->where('any','.*');
