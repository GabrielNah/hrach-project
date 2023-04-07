<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        if (!$product || empty($product->toArray())){
            return  $this->errorResponse(['err'=>'Product not found']);
        }
        $product->load(['tags',
            'nonGeneralFiles',
            'generalFile',
            'additional',
            'prices',
            'category.parentCategory',
            'sizes',
            'colors',
            'comments'=>function($q){
                    $q->where('active',true);
            }]);
        return  $this->successResponse([
            'product'=>ProductResource::make($product)
        ]);
    }
}
