<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller
{
   public function __invoke(): JsonResponse
   {
       $categories=Category::query()
                   ->where('in_header',true)
                   ->with('subCategories')
                   ->get();
       return $this->successResponse(compact('categories'));
   }
}
