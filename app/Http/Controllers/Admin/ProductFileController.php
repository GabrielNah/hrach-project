<?php

namespace App\Http\Controllers\Admin;

use App\Api\V1\Resources\ProductFileResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\UploadProductFileRequest;
use App\Models\File;
use App\Models\Product;
use App\Services\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\JsonResponse;


class ProductFileController extends Controller
{

    public function index(Product $product):\Symfony\Component\HttpFoundation\JsonResponse
    {
        $general = $product->generalFile()->first();
        $general->general = true;
        $non_general=$product->nonGeneralFiles()->get()->collect();
        $all = $non_general->push($general);
        return $this->successResponse([
            'files'=>ProductFileResource::collection($all)
        ]);
    }


    public function destroy(Product $product,File $file):\Symfony\Component\HttpFoundation\JsonResponse
    {
        try {

            $fileUrl = $file->path;
            $filePath = str_replace('storage/', '', $fileUrl);
            $file->delete();
            Storage::delete($filePath);
            return $this->deletedResponse();
        }catch (\Throwable $exception){
            return  $this->errorResponse(['e'=>$exception->getMessage()]);
        }
    }

    public function uploadOne(UploadProductFileRequest $request,Product $product,ProductRepository $productRepository):JsonResponse
    {
        try {

            $file =$productRepository->uploadOne($product,$request->file('uploaded_file'));
            return $this->successResponse([
                'file'=>ProductFileResource::make($file)
            ]);
        }catch (\Throwable $e){
            return $this->errorResponse(['e'=>$e->getMessage()]);
        }

    }


}
