<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\SiteAppearance;

class AppearanceController extends Controller
{
   public function __invoke(): \Symfony\Component\HttpFoundation\JsonResponse
   {
       $appearance=SiteAppearance::all();
       return $this->successResponse(compact('appearance'));
   }
}
