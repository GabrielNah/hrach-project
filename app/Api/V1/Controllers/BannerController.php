<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
   public function __invoke(): \Symfony\Component\HttpFoundation\JsonResponse
   {
       $banners=Banner::query()->get()->collect()->map(function ($slider){
           $slider->value = json_decode($slider->value,false);
           return $slider;
       });
       return $this->successResponse(compact('banners'));
   }
}
