<?php

namespace App\Services;

use App\Models\Color;
use App\Models\File;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

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
}
