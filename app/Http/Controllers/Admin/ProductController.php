<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Price;
use App\Models\Size;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    public function create():JsonResponse
    {
        $colors=Color::all();
        $sizes=Size::all();
        $categories=Category::query()->get();
        $currencies=Price::CURRENCIES;
        return  $this->successResponse(compact('colors','sizes','categories','currencies'));
    }


    public function store(StoreProductRequest $request):JsonResponse
    {
        return $this->successResponse(['gg'=>$request->all(),'type'=>$request->file('general_file')->getMimeType()]);
    }
}
