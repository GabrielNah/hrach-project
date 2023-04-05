<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\UpsertProductMetadataRequest;
use App\Models\Product;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductAdditionalController extends Controller
{
    public function index(Product $product):JsonResponse
    {
        return $this->successResponse([
            'additional'=>json_decode($product->additional->additional,true)
        ]);
    }

    public function edit(UpsertProductMetadataRequest $request,Product $product)
    {

          $metadata = $product->additional()->updateOrCreate([],[
              'additional'=>json_encode($request->validated())
          ]);
        return $this->successResponse(['metadata'=>json_decode($metadata->additional,true)]);
    }
}
