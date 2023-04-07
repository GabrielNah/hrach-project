<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentController extends Controller
{
    public function index(Product $product):JsonResponse
    {
        $comments = $product->comments()->get();
        return  $this->successResponse(compact('comments'));
    }

    public function store(Request $request,Product $product):JsonResponse
    {
        $request->validate([
            'rate'=>'required|numeric|min:1|max:5',
            'comment'=>'required|string|min:10|max:1000',
            'username'=>'required|string|min:4|max:50',
            'active'=>'required|bool'
        ]);
        $comment = $product->comments()->create([
            'rating'=>$request->input('rate'),
            'review'=>$request->input('comment'),
            'writer'=>$request->input('username'),
            'active'=>$request->boolean('active'),
        ]);

        return $this->successResponse(compact('comment'));
    }

    public function edit(Request $request,Comment $comment):JsonResponse
    {
        $request->validate([
            'rate'=>'required|numeric|min:1|max:5',
            'comment'=>'required|string|min:10|max:1000',
            'username'=>'required|string|min:4|max:50',
            'active'=>'required|bool'
        ]);
        $comment = tap($comment,function($comment) use ($request){
            $comment->rating = $request->input('rate');
            $comment->review = $request->input('comment');
            $comment->writer = $request->input('username');
            $comment->active = $request->boolean('active');
            $comment->save();
        });
        return $this->successResponse(compact('comment'));
    }

    public function destroy(Comment $comment):JsonResponse
    {
        $comment->delete();
        return $this->deletedResponse();
    }
}
