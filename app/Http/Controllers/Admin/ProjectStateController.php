<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectStateController extends Controller
{
    public function unreadInquiryExists():JsonResponse
    {
        return $this->successResponse([
           'unreadInquiryExists'=>Inquiry::query()->where('read',false)->exists()
        ]);
    }

    public function projectState()
    {
        $inquiry =[
            'total'=>Inquiry::query()->count(),
            'unread_count'=>Inquiry::query()->where('read',false)->count(),
        ];

        $product=[
          'total'=>Product::query()->count(),
          'in_stock'=>Product::query()->where('in_stock',true)->count()
        ];

        $subscriber=Subscriber::query()->count();

       return $this->successResponse(compact('product','subscriber','inquiry'));

    }
}
