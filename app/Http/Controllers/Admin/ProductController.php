<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Price;
use App\Models\Size;
use App\Services\ProductRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{

    public function __construct(private ProductRepository $productRepository)
    {
    }

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
        try {

            $this->productRepository->store($request->validated());
            return $this->successResponse(['gg'=>$request->validated()]);
        }catch (\Throwable $exception){
            return $this->errorResponse(['error'=>$exception->getMessage()]);
        }

    }
}
