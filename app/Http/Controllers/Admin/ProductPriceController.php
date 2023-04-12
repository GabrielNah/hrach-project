<?php

namespace App\Http\Controllers\Admin;

use App\Api\V1\Resources\PriceResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\Price\EditPriceRequest;
use App\Http\Requests\Admin\Product\Price\StorePriceRequest;
use App\Http\Requests\Admin\Product\UpsertPriceRequest;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
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

    public function store(StorePriceRequest $request,Product $product): JsonResponse
    {
        try {
            $price=$product->prices()->create($request->validated()['price']);

            return $this->successResponse([
                'price' => PriceResource::collection([$price])
            ]);

        }catch (\Throwable $exception){
            return $this->errorResponse(['e'=>$exception->getMessage()]);
        }
    }

    public function edit(EditPriceRequest $request,Product $product,Price $price):JsonResponse
    {
        try {
            $requestedData=$request->validated()['price'];
            $price->negotiable=$requestedData['negotiable'];
            $price->min_count=$requestedData['min_count'];
            $price->max_count=$requestedData['max_count'];
            $price->price=$requestedData['price'];
            $price->discount=$requestedData['discount'];
            $price->save();
            return $this->successResponse([
                'price' => PriceResource::collection([$price])
            ]);

        }catch (\Throwable $exception){
            return $this->errorResponse(['e'=>$exception->getMessage()]);
        }
    }

    public function destroy(Product $product,Price $price)
    {
        try {
            if ($product->prices()->count() === 1){
                throw new \InvalidArgumentException('Can`t remove last price of product');
            }

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
