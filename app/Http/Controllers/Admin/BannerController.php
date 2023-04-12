<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\EditBannerRequest;
use App\Http\Requests\Admin\Banner\StoreBannerRequest;
use App\Models\Banner;
use App\Services\FileService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class BannerController extends Controller
{
    public function __construct(private FileService $fileService)
    {
    }

    public function index():JsonResponse
    {
        $banners=Banner::query()->get();
        return $this->successResponse(compact('banners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request):JsonResponse
    {
        try {
           $banner = Banner::query()->create([
              ...$request->safe()->except(['value','image']),
              'value'=>collect($request->input('value'))
                  ->map(fn($id)=>(integer)$id)
                  ->toJson() ,
               'image'=>'*'
           ]);
           $path='public/banners/Banner_'.$banner->id;
            $storedPath = $this->fileService->storeFile($path,$request->file('image'));
           $banner->image = $storedPath;
           $banner->save();
           return $this->createdResponse();

        }catch (\Throwable $e){
            return $this->errorResponse(['e'=>$e->getMessage()]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EditBannerRequest $request, Banner $banner):JsonResponse
    {
        try {
            if (!$banner || empty($banner->toArray())){
                throw  new ModelNotFoundException('No banner found under id'.\request()->route('banner'));
            }
            $banner->update([
                ...$request->safe()->except(['value','image']),
                'value'=>collect($request->input('value'))
                    ->map(fn($id)=>(integer)$id)
                    ->toJson() ,
            ]);
            if ($request->hasFile('image')){
                $path='public/banners/Banner_'.$banner->id;
                $storedPath = $this->fileService->storeFile($path,$request->file('image'));
                $this->fileService->removeFile($banner->image);
                $banner->image = $storedPath;
                $banner->save();
            }
            return $this->successResponse();

        }catch (\Throwable $e){
            return $this->errorResponse(['e'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner): JsonResponse
    {
        try {
            if (!$banner || empty($banner->toArray())){
                throw  new ModelNotFoundException('No banner found under id'.\request()->route('banner'));
            }
            $file=$banner->image;
            $banner->delete();
            $this->fileService->removeFile($file);
            return $this->deletedResponse();
        }catch (\Throwable $e){
            return $this->errorResponse(['e'=>$e->getMessage()]);
        }
    }
}
