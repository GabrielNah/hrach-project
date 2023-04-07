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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
            if ($size?->type !==Size::TYPE_INDIVIDUAL){
                throw new \InvalidArgumentException('Can\'t remove non individual size');
            }
            DB::beginTransaction();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $product->sizes()->detach([$size->id]);
            $size->delete();
            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return  $this->deletedResponse();
        }catch (\Throwable $e){
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            return $this->errorResponse(['e'=>$e->getMessage()]);
        }
    }


    public function upsert(Request $request,Product $product,Size $size): JsonResponse
    {
        $request->validate([
            'size'=>'required|string'
        ]);

        try {
            DB::beginTransaction();

            if (!$request->route('size')){
                $size = new Size([
                    'type'=>Size::TYPE_INDIVIDUAL
                ]);
            }
            $size->size = $request->input('size');

            $size->save();
            if (!$request->route('size')){
                $product->sizes()->attach($size->id);
            }
            DB::commit();
            return $this->successResponse(compact('size'));
        }catch (\Throwable $exception){
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            return $this->errorResponse(['e'=>$exception->getMessage()]);
        }

    }

    public function editGeneralColors(Request $request,Product $product):JsonResponse
    {
        $request->validate([
            'colors' => 'array|present',
            'colors.*' => 'integer|exists:colors,id'
        ]);
        $globalsIds = $product->colors()
            ->where('type', Color::TYPE_GLOBAL)
            ->pluck('color_id')->toArray();
        $product->colors()->detach($globalsIds);
        $product->colors()
            ->where('type', Size::TYPE_GLOBAL)
            ->syncWithoutDetaching($request->input('colors'));
        return $this->successResponse();

    }

    public function deleteIndividualColor(Product $product,Color $color):JsonResponse
    {

        try {

            if ($color?->type !== Color::TYPE_INDIVIDUAL){
                throw new \InvalidArgumentException('Cant\'t remove non individual color');
            }
            DB::beginTransaction();
            $fileUrl = $color->value;
            $file_path = str_replace('storage','/app/public',$fileUrl);
            $product->colors()->detach([$color->id]);
            $color->delete();
            if (File::exists(storage_path($file_path))){
                File::delete(storage_path($file_path));
            };
            DB::commit();
            return $this->deletedResponse();
        }catch (\Throwable $exception){
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            return $this->errorResponse(['e'=>$exception->getMessage()]);
        }

    }

    public function upsertColors(Request $request,Product $product,Color $color):JsonResponse
    {

        $request->validate([
            'name'=>'nullable|string'.($request->route('color') ? '' : '|required'),
            'value'=>'nullable|file'.($request->route('color') ? '' : '|required'),
        ]);
        try {

            DB::beginTransaction();
            if (!$request->route('color')){
                 $color = new Color([
                     'type'=>Color::TYPE_INDIVIDUAL
                 ]);
                $file = $request->file('value');
                $path = '/public/Product' . $product->id.'/Colors';
                $filePath = $file->store($path);
                $color->value =  str_replace('public', 'storage', $filePath);
                $color->name = $request->input('name');
            }
            if ($request->route('color')){
                if ($request->input('name')){
                    $color->name = $request->input('name');
                }
                if ($request->hasFile('value')){
                    $file = $request->file('value');
                    $path = '/public/Product' . $product->id.'/Colors';
                    $filePath = $file->store($path);
                    $file_path = str_replace('storage','/app/public',$color->value);
                    if (File::exists(storage_path($file_path))){
                        File::delete(storage_path($file_path));
                    };
                    $color->value =  str_replace('public', 'storage', $filePath);
                }
            }
            $color->save();
            if (!$request->route('color')){
                $product->colors()->attach($color->id);
            }
            DB::commit();
            return $this->successResponse(compact('color'));
        }catch (\Throwable $exception){
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            return $this->errorResponse(['e'=>$exception->getMessage()]);
        }
    }
}
