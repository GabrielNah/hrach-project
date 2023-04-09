<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\StoreSliderRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Slider;
use App\Models\Tag;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SliderController extends Controller
{

    public function getInitialDataForSearchHelp():JsonResponse
    {
        $tags=Tag::query()->select(['id','name'])->get();
        $colors=Color::query()->select(['id','name',])->where('type',Color::TYPE_GLOBAL)->get();
        $sizes=Size::query()->select(['id','size'])->where('type',Color::TYPE_GLOBAL)->get();
        $categories=Category::query()->select('id','name')->where('active','1')->get();
        return $this->successResponse(compact('sizes','colors','tags','categories'));

    }

    public function store(StoreSliderRequest $request):JsonResponse
    {
        $slider=Slider::query()->create([
            'title'=>$request->input('title'),
            'link_text'=>$request->input('link_text'),
            'value'=>collect($request->input('value'))->map(fn($id)=>(integer) $id)->toJson(),
            'image'=>'',
        ]);
       $this->storeFile($slider,$request->file('image'));
       return $this->createdResponse();

    }

    private function storeFile(Slider $slider,$file ):void
    {
        $path = '/public/Slider_' . $slider->id;
        $filePath = $file->store($path);

        $slider->update(['image'=>str_replace('public', 'storage', $filePath)]);
    }
}
