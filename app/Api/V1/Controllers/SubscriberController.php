<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\SubscribeRequest;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
   public function __invoke(SubscribeRequest $request): \Symfony\Component\HttpFoundation\JsonResponse
   {
       Subscriber::query()->create([
           'subscriber'=>$request->input('subscriber')
       ]);
       return $this->successResponse();
   }
}
