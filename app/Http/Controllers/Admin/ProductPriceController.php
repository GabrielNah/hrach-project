<?php

namespace App\Http\Controllers\Admin;

use App\Api\V1\Resources\PriceResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\UpsertPriceRequest;
use App\Models\Price;
use App\Models\Product;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductPriceController extends Controller
{
    public function index(Product $product): JsonResponse
    {
        $prices = $product->prices()->get();

        return $this->successResponse([
           'prices' => PriceResource::collection($prices)
        ]);
    }

    public function upsert(UpsertPriceRequest $request,Product $product,Price $price): JsonResponse
    {
        $data = [
            'min_count'=>$request->input('min_count'),
            'max_count'=>$request->input('max_count'),
            'price'=>$request->input('price'),
        ];
        if ($price?->id){
            $price = tap($price,fn()=>$price->update($data));
        }
        if (!$price?->id){
            $price = $product->prices()->create($data);
        }
        return $this->successResponse(compact('price'));
    }


}
