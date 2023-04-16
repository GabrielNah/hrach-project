<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class InquiryController extends Controller
{
    public function index():JsonResponse
    {
        $inquires=Inquiry::query()
                ->with('product.generalFile')
                ->latest('id')
                ->paginate(8);
        return $this->successResponse([
           'inquiries'=>$inquires->items(),
           'next_page_url'=>$inquires->nextPageUrl(),
        ]);
    }

    public function read(int $id):JsonResponse
    {
        $inquiry=Inquiry::query()->find($id);

        if (!$inquiry){
            return $this->errorResponse(['e'=>'Inquiry not found']);
        }
        if (!$inquiry->read){
            $inquiry->update(['read'=>true]);
        }

        $inquiry->load([
            'product.generalFile',
            'product.priceForOne',
        ]);

        return $this->successResponse(compact('inquiry'));

    }
}
