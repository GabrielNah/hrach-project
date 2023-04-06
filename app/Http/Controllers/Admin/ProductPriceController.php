<?php

namespace App\Http\Controllers\Admin;

use App\Api\V1\Resources\PriceResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\UpsertPriceRequest;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function upsert(UpsertPriceRequest $request,Product $product): JsonResponse
    {
        try {
            $product->prices()->delete();

            foreach ($request->validated()['prices'] as $price){
               $product->prices()->create($price);
            }
            return $this->successResponse([
                'prices' => PriceResource::collection($product->prices()->get())
            ]);

        }catch (\Throwable $exception){
            return $this->errorResponse(['e'=>$exception->getMessage()]);
        }
    }

    public function destroy(Product $product,Price $price)
    {
        try {

            if (!$price && empty($price->toArray())){
                throw new ModelNotFoundException('Price under ID:'.request()->route('price').' not found');

            }
                $price->delete();
                return $this->deletedResponse();
        }catch (\Throwable $exception){
            return $this->errorResponse(['e'=>$exception->getMessage()]);
        }

    }


}
