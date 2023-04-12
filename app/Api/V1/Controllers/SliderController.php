<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller
{
   public function __invoke(): \Symfony\Component\HttpFoundation\JsonResponse
   {
       $sliders=Slider::query()->get()->collect()->map(function ($slider){
           $slider->value = json_decode($slider->value,false);
           return $slider;
       });
       return $this->successResponse(compact('sliders'));
   }
}
