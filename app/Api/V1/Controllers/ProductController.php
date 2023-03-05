<?php

namespace App\Api\V1\Controllers;

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
            'additional',
            'sizes',
            'tags',
            'colors'
        ]);

        return $this->successResponse([
            'product'=>$product
        ]);
    }
}
