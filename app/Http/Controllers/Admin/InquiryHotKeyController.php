<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotKey;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class InquiryHotKeyController extends Controller
{
    public function index():JsonResponse
    {
        $hotKeys=HotKey::query()->get();
        return $this->successResponse(compact('hotKeys'));
    }

    public function store(Request $request):JsonResponse
    {
        $request->validate([
            'key'=>'required|string|unique:'.HotKey::TABLE
        ]);
        $key=$request->input('key');
        $hot_key=HotKey::query()->create(compact('key'));

        return $this->successResponse(compact('hot_key'));
    }

    public function edit(Request $request,int $id): JsonResponse
    {
        $request->validate([
            'key'=>'required|string|unique:'.HotKey::TABLE.',key,'.$id
        ]);

        $hot_key= HotKey::query()->find($id);
       if (!$hot_key){
           return $this->errorResponse(['e'=>'Not found']);
       }
        $hot_key->key=$request->input('key');
        $hot_key->save();
       return $this->successResponse(compact('hot_key'));

    }

    public function destroy(int $id):JsonResponse
    {
            $key = HotKey::query()->find($id);
            if (!$key){
                return $this->errorResponse(['e'=>'Not found']);
            }
            $key->delete();
            return $this->deletedResponse();
    }
}
