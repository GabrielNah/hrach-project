<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        if (!$product){
            return $this->errorResponse([
                'err'=>'Product not found'
            ]);
        }

        $product->load([
            'nonGeneralFiles',
            'generalFile',
            'category.parentCategory',
            'prices',
            'additional'
        ]);
        $product->colors=$product->getColors();
        $product->sizes=$product->getSizes();

        return $this->successResponse([
            'product'=>ProductResource::make($product)
        ]);
    }
}
