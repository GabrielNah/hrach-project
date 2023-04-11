<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HomePageSettings\EditHomePageSettingRequest;
use App\Http\Requests\Admin\HomePageSettings\StoreHomePageSettingRequest;
use App\Models\HomePageSettings;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomePageSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        $setting=HomePageSettings::query()->get()->collect();
        $setting->each(function ($setting){
            $setting->products=json_decode($setting->products,false);
        });
        return $this->successResponse(compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHomePageSettingRequest $request):JsonResponse
    {

        $products=collect($request->input('products'))->map(fn($pr)=>(int)$pr)->toJson();
        $settings=HomePageSettings::query()->create([
            ...$request->safe()->except('products'),
            ...compact('products')
        ]);

        return $this->successResponse(compact('settings'));
    }

    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(EditHomePageSettingRequest $request,int $id):JsonResponse
    {
        $homePageSettings=HomePageSettings::query()->find($id);
        $products=collect($request->input('products'))->map(fn($pr)=>(int)$pr)->toJson();
        $homePageSettings->update([
            ...$request->safe()->except('products'),
            ...compact('products')
        ]);
        return $this->successResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        HomePageSettings::query()->where('id',$id)->delete();
        return $this->deletedResponse();
    }
}
