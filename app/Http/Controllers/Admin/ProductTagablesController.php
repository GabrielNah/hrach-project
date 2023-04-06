<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductTagablesController extends Controller
{
    public function index(Product $product):JsonResponse
    {
        try {
            if (!$product || empty($product->toArray())){
                throw  new ModelNotFoundException('No product found under ID:'.\request()->route('product'));
            }
            $product->load(['sizes','tags','colors']);
            $sizes = Size::query()->where('type',Size::TYPE_GLOBAL)->get();
            $colors = Color::query()->where('type',Color::TYPE_GLOBAL)->get();
            $tags = Tag::query()->get();
            return $this->successResponse(compact('product','colors','tags','sizes'));

        }catch (\Throwable $exception){
            return $this->errorResponse([
                'e'=>$exception->getMessage()
            ]);
        }

    }

    public function editTags(Request $request,Product $product):JsonResponse
    {
        $request->validate([
           'tags'=>'array|present',
           'tags.*'=>'integer|exists:tags,id'
        ]);
        $product->tags()->sync($request->input('tags'));
        return $this->successResponse();
    }

    public function editGeneralSizes(Request $request,Product $product):JsonResponse
    {
        $request->validate([
            'sizes'=>'array|present',
            'sizes.*'=>'integer|exists:sizes,id'
        ]);
        $globalsIds = $product->sizes()
            ->where('type',Size::TYPE_GLOBAL)
            ->pluck('size_id')->toArray();
        $product->sizes()->detach($globalsIds);
        $product->sizes()
            ->where('type',Size::TYPE_GLOBAL)
            ->syncWithoutDetaching($request->input('sizes'));
        return $this->successResponse();
    }

    public function destroySize(Product $product,Size $size): JsonResponse
    {
        try {
            DB::beginTransaction();
            $product->sizes()->detach([$size->id]);
            $size->delete();
            DB::commit();
            return  $this->deletedResponse();
        }catch (\Throwable $e){
            DB::rollBack();
            return $this->errorResponse(['e'=>$e->getMessage()]);
        }

    }
}
