<?php

namespace App\Services;

use App\Models\Color;
use App\Models\File;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{
    public function store(array $productData)
    {
        try {
            DB::beginTransaction();
            $product=Product::query()->create($productData['product_data']);
            $product->additional()->create(['additional'=>$productData['additional']]);

            foreach ($productData['prices'] as $priceData){
                $product->prices()->create($priceData);
            }
            if (count($productData['tags'] ?? [])){
                $product->tags()->attach($productData['tags']);
            }
            if (count($productData['colors'] ?? []) || count(\request()->file('individual_colors') ?? [])){
                $colors=$productData['colors'] ?? [];
                if (\request()->hasFile('individual_colors')){
                    foreach (\request()->file('individual_colors') as $index=> $file){
                        $path = '/public/Product' . $product->id.'/Colors';
                        $filePath = $file->store($path);
                        $color= Color::query()->create([
                            'type' => Color::TYPE_INDIVIDUAL,
                            'name' => $productData['individual_colors_name'][$index],
                            'value' => str_replace('public', 'storage', $filePath)
                        ]);
                        $colors[]=$color->id;
                    }
                }
                $product->colors()->attach($colors);

            }
            if (count($productData['sizes'] ?? []) || count($productData['individual_size_name'] ?? [])) {
                $sizes=$productData['sizes'] ?? [];
                if ($productData['individual_size_name']){
                    foreach ($productData['individual_size_name'] as $individual_size){
                        $size=Size::query()->create([
                            'size'=>$individual_size,
                            'type'=>Size::TYPE_INDIVIDUAL
                        ]);
                        $sizes[]=$size->id;
                    }
                }
                $product->sizes()->attach($sizes);
            }

            $generalFile=\request()->file('general_file');
            $this->uploadOne($product,$generalFile,'1');
            if (\request()->has('files')){
                foreach (\request()->file('files') as $file) {
                    $this->uploadOne($product,$file);
                }
            }
            DB::commit();
            return $product->id;
        }catch (\Throwable $e){
            DB::rollBack();
            throw new \RuntimeException($e->getMessage());

        }
    }

    public function uploadOne(Product $product,$file,$general='0')
    {
        $mime = $file->getClientMimeType();
        $fileType = '';
        if (str_contains($mime, 'video')) {
            $fileType = File::VIDEO;
        }
        if (str_contains($mime, 'image')) {
            $fileType = File::IMAGE;
        }
        if (!in_array($fileType, File::FILE_TYPES)) {
            throw new \RuntimeException('Files type does not match requirements');
        }
        $path = '/public/Product' . $product->id;
        $filePath = $file->store($path);
        return $product->files()->create([
            'type' => $fileType,
            'general' => $general,
            'path' => str_replace('public', 'storage', $filePath)
        ]);
    }


    public function index(Request $request):LengthAwarePaginator
    {

        return  Product::query()
                    ->when($request->query('search'),function (Builder $builder) use ($request){
                        return $builder->where('name','LIKE','%'.$request->query('search').'%')
                                       ->orWhere('title','LIKE','%'.$request->query('search').'%')
                                       ->orWhere('description','LIKE','%'.$request->query('search').'%')
                                        ->orWhereHas('category', function (Builder $q) use ($request) {
                                            $q->where('name', 'LIKE', '%' . $request->query('search') . '%');
                                        });
                    })
                    ->with(['generalFile','priceForOne','category'])
                    ->paginate($request->query('count')??2);
    }


    public function destroy(Product $product):void
    {
        try {
            DB::beginTransaction();
            $product->prices()->delete();
            $product->additional()->delete();
            $product->tags()->detach();
            Size::query()->whereIn('id',$product->sizes()->pluck('size_id')
                ->toArray())
                ->where('type',Size::TYPE_INDIVIDUAL)
                ->delete();
            $product->sizes()->detach();

            $individual = $product->colors()
                ->where('type',Color::TYPE_INDIVIDUAL)
                ->get();
            foreach ($individual as $color){
                     $product->colors()->detach($color->id);
                     $this->removeFile($color->value);
                     Color::query()->where('id',$color->id)->delete();
            }

            foreach ($product->files as $file){
                 $this->removeFile($file->path);
                 File::query()->where('id',$file->id)->delete();
                Storage::deleteDirectory('public/Product'.$product->id);
            }
            $product->delete();
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            throw new \LogicException($e->getMessage());
        }
    }

    private function removeFile(string $path):void
    {
        $file_path = str_replace('storage','/app/public',$path);
        if (\Illuminate\Support\Facades\File::exists(storage_path($file_path))){
            \Illuminate\Support\Facades\File::delete(storage_path($file_path));
        };
    }

    public function search(Request $request):LengthAwarePaginator
    {
        return Product::query()
            ->with('priceForOne','generalFile','tags')
            ->when($request->input('type')==='default',function (Builder $q)use ($request){
                $q->where('name','LIKE','%'.$request->input('value').'%')
                    ->orWhere('title','LIKE','%'.$request->input('value').'%')
                    ->orWhere('description','LIKE','%'.$request->input('value').'%');
            })
            ->when($request->input('type')==='tags',function (Builder $q)use ($request){
                $q->whereHas('tags',function (Builder $q)use ($request){
                    $q->where('name','LIKE','%'.$request->input('value').'%')
                        ->orWhere('description','LIKE','%'.$request->input('value').'%');
                });
            })
            ->when($request->input('type')==='categories',function (Builder $q)use ($request){
                $q->whereHas('category',function (Builder $q)use ($request){
                    $q->where('name','LIKE','%'.$request->input('value').'%');
                });
            })
            ->when($request->input('type')==='sizes',function (Builder $q)use ($request){
                $q->whereHas('sizes',function (Builder $q)use ($request){
                    $q->where('size','LIKE','%'.$request->input('value').'%');
                });
            })
            ->when($request->input('type')==='colors',function (Builder $q)use ($request){
                $q->whereHas('colors',function (Builder $q)use ($request){
                    $q->where('name','LIKE','%'.$request->input('value').'%');
                });
            })
            ->when($request->input('type')==='discounts',function (Builder $q)use ($request){
                $q->whereHas('prices',function (Builder $q)use ($request){
                    $q->where('discount',$request->input('operator'),$request->input('value'));
                });
            })
            ->paginate(2);

    }
}
