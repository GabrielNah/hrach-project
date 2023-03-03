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
            $generalFile=\request()->file('general_file');
            $mime = $generalFile->getClientMimeType();
            $fileType='';
            if (str_contains($mime, 'video')) {
              $fileType=File::VIDEO;
            }
            if (str_contains($mime, 'image')) {
                $fileType=File::IMAGE;
            }
            if (!in_array($fileType,File::FILE_TYPES)){
                throw new \RuntimeException('Files type does not match requirements');
            }
            $path='/Product'.$product->id;
            $filePath=$generalFile->store($path);
            $product->files()->create([
                'type'=>$fileType,
                'general'=>'1',
                'path'=>$filePath
               ]);
            if (\request()->has('files')){
                foreach (\request()->file('files') as $file) {
                    $mime = $file->getClientMimeType();
                    $fileType='';
                    if (str_contains($mime, 'video')) {
                        $fileType=File::VIDEO;
                    }
                    if (str_contains($mime, 'image')) {
                        $fileType=File::IMAGE;
                    }
                    if (!in_array($fileType,File::FILE_TYPES)){
                        throw new \RuntimeException('Files type does not match requirements');
                    }
                     $path='/Product'.$product->id;
                    $filePath=$file->store($path);
                    $product->files()->create([
                        'type'=>$fileType,
                        'general'=>'0',
                        'path'=>$filePath
                    ]);

                }
            }
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            throw new \RuntimeException($e->getMessage());

        }
    }
}
