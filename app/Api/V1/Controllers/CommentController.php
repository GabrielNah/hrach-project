<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\LeaveCommentRequest;
use App\Http\Controllers\Controller;
use App\Models\Product;

class CommentController extends Controller
{
   public function __invoke(LeaveCommentRequest $request,Product $product): \Symfony\Component\HttpFoundation\JsonResponse
   {
       $comment = $product->comments()->create([
           'writer'=>$request->input('username'),
           'review'=>$request->input('comment'),
           'rating'=>$request->input('rating'),
           'active'=>true
       ]);
       return $this->successResponse(compact('comment'));
   }
}
