<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;


class SubscriberController extends Controller
{
    public function __invoke(): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $subscribers = Subscriber::query()->get();
        return $this->successResponse(compact('subscribers'));
    }
}
