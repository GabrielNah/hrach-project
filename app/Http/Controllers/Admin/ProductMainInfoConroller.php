<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\EditProductMainInfoRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductMainInfoConroller extends Controller
{
    public function index(Product $product):JsonResponse
    {
        return  $this->successResponse(
            [
                'product'=>$product->load('category'),
                'categories'=>Category::query()->where('active','1')->get()
            ]
        );
    }

    public function edit(EditProductMainInfoRequest $request,Product $product):JsonResponse
    {
        $product = tap($product,function ($product) use ($request){
            $product->name = $request->name;
            $product->title = $request->title;
            $product->description = $request->description;
            $product->rating = $request->rating;
            $product->category_id = $request->category;
            $product->active = $request->active ? '1' : '0';
            $product->in_stock = $request->boolean('in_stock') ;
            $product->save();
        });

        return $this->successResponse([
            'product'=>$product->load('category'),
        ]);
    }
}
