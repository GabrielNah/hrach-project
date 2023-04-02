<?php

namespace App\Services;

use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function store(array $productData)
    {
        try {
            DB::beginTransaction();
            $product=Product::query()->create($productData['product_data']);
            $product->additional()->create(['additional'=>$productData['additional']]);
            foreach ($productData['prices_for_many'] as $priceData){
                $product->prices()->create($priceData);
            }
            foreach ($productData['prices_for_one'] as $priceData){
                $product->prices()->create(array_merge($priceData,['min_count'=>1,'max_count'=>1]));
            }
            if (count($productData['tags'])){
                $product->tags()->attach($productData['tags']);
            }
            if (count($productData['colors'])){
                $product->sizes()->attach($productData['colors']);
            }
            if (count($productData['tags'])){
                $product->colors()->attach($productData['sizes']);
            }
            $generalFile=\request()->file('general_file');
            $this->uploadOne($product,$generalFile,'1');
            if (\request()->has('files')){
                foreach (\request()->file('files') as $file) {
                    $this->uploadOne($product,$file);
                }
            }
            DB::commit();
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
