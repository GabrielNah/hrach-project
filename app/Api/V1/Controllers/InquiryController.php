<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\SendInquiryRequest;
use App\Http\Controllers\Controller;
use App\Models\HotKey;
use App\Models\Inquiry;
use Symfony\Component\HttpFoundation\JsonResponse;

class InquiryController extends Controller
{
   public function __invoke(SendInquiryRequest $request): JsonResponse
   {
       Inquiry::query()->create($request->validated());
       return $this->createdResponse();
   }

    public function getHotKeys():JsonResponse
    {
        $hot_keys=HotKey::query()->pluck('key');
        return $this->successResponse(compact('hot_keys'));
    }
}
