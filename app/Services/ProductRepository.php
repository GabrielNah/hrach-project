<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function store(array $productData)
    {
        try {
            DB::beginTransaction();
            $product=Product::query()->create();
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();

        }
    }
}
