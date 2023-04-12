<?php

namespace App\Services;

use App\Models\Slider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function storeFile(string $path,$file):string
    {
        $filePath = $file->store($path);
        return str_replace('public', 'storage', $filePath);
    }


    public function removeFile(string $path):void
    {
        $file_path = str_replace('storage','/app/public',$path);
        if (File::exists(storage_path($file_path))){
            File::delete(storage_path($file_path));
        };
    }

    public function removeDir(string $dir):void
    {
        Storage::deleteDirectory($dir);
    }
}
