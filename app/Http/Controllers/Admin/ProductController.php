<?php

namespace App\Http\Controllers\Admin;

use App\Api\V1\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Models\Category;
use App\Models\Color;
use App\Models\Price;
use App\Models\Product;
use App\Models\Size;
use App\Models\Tag;
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
        $colors=Color::query()->where('type',Color::TYPE_GLOBAL)->get();
        $sizes=Size::query()->where('type',Color::TYPE_GLOBAL)->get();
        $categories=Category::query()->where('active','1')->get();
        $tag=Tag::all();
        return  $this->successResponse(compact('colors','sizes','categories','tag'));
    }


    public function store(StoreProductRequest $request):JsonResponse
    {
        try {
            $product_id = $this->productRepository->store($request->validated());
            return $this->createdResponse(compact('product_id'));
        }catch (\Throwable $exception){
            info($exception->getTraceAsString());
            return $this->errorResponse(['error'=>$exception->getMessage()]);
        }
    }

    public function show(Product $product):JsonResponse
    {
       if (!$product || empty($product->toArray())){
           return  $this->errorResponse(['err'=>'Product not found']);
       }
       $product->load(['tags','nonGeneralFiles','generalFile','additional','prices','category.parentCategory','sizes','colors']);
       return  $this->successResponse([
           'product'=>ProductResource::make($product)
       ]);
    }
}
