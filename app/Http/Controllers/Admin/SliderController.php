<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Tag;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SliderController extends Controller
{
    public function index():JsonResponse
    {

    }

    public function getInitialDataForSearchHelp():JsonResponse
    {
        $tags=Tag::query()->select(['id','name'])->get();
        $colors=Color::query()->select(['id','name',])->where('type',Color::TYPE_GLOBAL)->get();
        $sizes=Size::query()->select(['id','size'])->where('type',Color::TYPE_GLOBAL)->get();
        $categories=Category::query()->select('id','name')->where('active','1')->get();
        return $this->successResponse(compact('sizes','colors','tags','categories'));

    }
}
