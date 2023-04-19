<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\SearchProductsRequest;
use App\Api\V1\Resources\ProductResource;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\HomePageSettings;
use App\Models\Product;
use App\Models\Size;
use App\Models\Tag;
use App\Services\Enums\SEARCH_TYPES;
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
            'prices:id,product_id,min_count,max_count,price,discount,negotiable',
            'category.parentCategory',
            'sizes:id,size,type',
            'colors:id,type,name,value',
            'comments'=>function($q){
                    $q->select(['id','product_id','writer','review','rating'])
                    ->where('active',true);
            }]);

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
        return  $this->successResponse([
            'product'=>ProductResource::make($product),
            'related'=>$related,
            'likable'=>$likable
        ]);
    }


    public function search(SearchProductsRequest $request):JsonResponse
    {
        $SEARCH_TYPE=$request->input('type');
        $products=Product::query()
            ->with(['generalFile','priceForOne','tags'])
            ->when(($SEARCH_TYPE === SEARCH_TYPES::CATEGORY->value &&
                $request->input('category')!=='all') ,function (Builder $q) use ($request){
                $q->whereHas('category',function ($q) use ($request){
                    $q->where('name',$request->input('category'))
                        ->orWhereHas('parentCategory',function ($q) use ($request){
                                $q->where('name',$request->input('category'));
                        });
                });
            })
            ->when($SEARCH_TYPE === SEARCH_TYPES::IDS->value,function (Builder $q) use ($request){
                $q->whereIn('id',$request->input('ids'));
            })
            ->when($SEARCH_TYPE === SEARCH_TYPES::DEFAULT->value,function (Builder $q)use ($request){
                $val=$request->input('value');
                $q->where(function (Builder $q) use ($val){
                      $q->where('name','LIKE',"%$val%")
                        ->orWhere('title','LIKE',"%$val%")
                        ->orWhere('description','LIKE',"%$val%");
                })->orWhereHas('category',function ($q)use ($val){
                    $q->where('name','LIKE',"$val");
                })->orWhereHas('tags',function ($q)use ($val){
                        $q->where('name','LIKE',"$val")
                        ->orWhere('description','LIKE',"$val");
                    });
            })
            ->when($SEARCH_TYPE === SEARCH_TYPES::FILTER->value,function (Builder $q)use ($request){
                $val=$request->input('filter');
                $tags= $val['tags'] ?? null;
                $sizes= $val['sizes'] ?? null;
                $colors= $val['colors'] ?? null;
                $rating= $val['rating'] ?? null;
                $categories= $val['categories'] ?? null;
                $min_price=$val['price_min']??null;
                $max_price=$val['price_max']??null;
                $q->when($tags,function (Builder $q) use ($tags){
                    $q->whereHas('tags',function ($query) use ($tags){
                        $query->whereIn('tag_id',$tags);
                    });
                })->when($sizes,function (Builder $q) use ($sizes){
                    $q->whereHas('sizes',function ($query) use ($sizes){
                        $query->whereIn('size_id',$sizes);
                    });
                })->when($colors,function (Builder $q) use ($colors){
                    $q->whereHas('colors',function ($query) use ($colors){
                        $query->whereIn('color_id',$colors);
                    });
                })->when($categories,function (Builder $q) use ($categories){
                    $q->whereHas('category',function ($query) use ($categories){
                        $query->whereIn('id',$categories);
                    });
                })->when($rating,function (Builder $q) use ($rating){
                    $q->whereIn('rating',$rating);
                })->when($min_price && $max_price,function (Builder $q) use ($min_price,$max_price){
                    $q->whereHas('priceForOne',function ($query) use ($min_price,$max_price){
                        $query->whereBetween('price',[$min_price,$max_price]);
                    });
                });
            })
            ->paginate(20);
        return $this->successResponse(compact('products'));
    }

    public function giveSearchHelpers():JsonResponse
    {
        $tags=Tag::query()->get();
        $colors=Color::query()->where('type',Color::TYPE_GLOBAL)->get();
        $sizes=Size::query()->where('type',Size::TYPE_GLOBAL)->get();
        $categories=Category::query()->where('active','1')->get();
        return $this->successResponse(compact('sizes','categories','colors','tags'));

    }


    public function getFrontPageProducts():JsonResponse
    {
        $main=\request()->boolean('main');
        $pageSettings=HomePageSettings::query()->where('main',$main)->first(['id','main','products','showable_count','section_name']);
        if ($pageSettings){
            $ids=json_decode($pageSettings->products,false);
            $query=Product::query()
                ->whereIn('id',$ids)
                ->with(['priceForOne','generalFile','tags']);

                if ($main){
                        $products=$query->paginate($pageSettings->showable_count);
                    }
                if (!$main){
                    $products=$query->get();
                }
            if ($main){
                $products=[
                    'products'=>$products->items(),
                    'next_page_url'=>$products->nextPageUrl()
                ];
            }
            $pageSettings->products=$products;
            return $this->successResponse(compact('pageSettings'));
        }

        return $this->errorResponse(['e'=>'Setting not found']);

    }

}
