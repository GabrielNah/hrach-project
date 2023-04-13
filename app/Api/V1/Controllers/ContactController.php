<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use App\Models\Slider;
use App\Models\SocialMedia;

class ContactController extends Controller
{
   public function __invoke(): \Symfony\Component\HttpFoundation\JsonResponse
   {
       $socialMedia=SocialMedia::query()->get();
       $contactInfo=ContactInfo::query()->first();
       return $this->successResponse(compact('socialMedia','contactInfo'));
   }
}
