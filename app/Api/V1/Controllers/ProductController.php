<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    public function show(Product $product): JsonResponse
    {
        if (!$product || empty($product->toArray())){
            return  $this->errorResponse(['err'=>'Product not found']);
        }


        $product->load([
            'tags:id,name,description',
            'nonGeneralFiles:id,product_id,path,type',
            'generalFile:id,product_id,path,type',
            'additional:id,product_id,additional',
            'prices:id,product_id,min_count,max_count,price,discount',
            'category.parentCategory',
            'sizes:id,size,type',
            'colors:id,type,name,value',
            'comments'=>function($q){
                    $q->select(['id','product_id','writer','review','rating'])
                    ->where('active',true);
            }]);
        $likable=[];
        $related=[];
        if (!auth('admin')->check()){
            $tags=collect($product->tags)->pluck('id')->values()->all();
            $category=$product->category->id;
            $likable=Product::query()
                ->where('id','!=',$product->id)
                ->with([
                    'generalFile:id,product_id,path,type',
                    'priceForOne:id,product_id,min_count,max_count,price,discount'
                ])
                ->whereHas('tags',function ($q)use ($tags){
                    $q->whereIn('tag_id',$tags);
                })
                ->take(20)
                ->get();
            $related=Product::query()
                ->where('id','!=',$product->id)
                ->with([
                    'generalFile:id,product_id,path,type',
                    'priceForOne:id,product_id,min_count,max_count,price,discount'
                ])
                ->whereHas('category',function ($q)use ($category){
                    $q->where('category_id',$category);
                })
                ->take(20)
                ->get();
        }
        return  $this->successResponse([
            'product'=>ProductResource::make($product),
            'related'=>$related,
            'likable'=>$likable

        ]);
    }

}
