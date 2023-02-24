<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\EditColorRequest;
use App\Http\Requests\Admin\Settings\StoreColorRequest;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SettingController extends Controller
{
    public function getSettings():JsonResponse
    {
        $colors=Color::all();
        $sizes=Size::all();
        return $this->successResponse(compact('sizes','colors'));
    }

    public function storeColor(StoreColorRequest $request):JsonResponse
    {
        $color=Color::create($request->validated());
        return $this->createdResponse(compact('color'));
    }

    public function editColor(int $id,EditColorRequest $request):JsonResponse
    {
        Color::where('id',$id)->update($request->validated());
        return $this->successResponse();
    }

    public function deleteColor(int $id):JsonResponse
    {
        Color::where('id',$id)->delete();
        return $this->deletedResponse();
    }


    public function storeSize(Request $request):JsonResponse
    {
        $validated=$request->validate([
            'size'=>'required|string|unique:sizes,size'
        ]);
        $size=Size::query()->create($validated);
        return $this->successResponse(compact('size'));
    }


    public function editSize(int $id,Request $request):JsonResponse
    {
        $validated=$request->validate([
            'size'=>'required|string|unique:sizes,size,'.$id
        ]);
        Size::query()->where('id',$id)->update($validated);
        return  $this->successResponse();
    }

    public function removeSize(int $id):JsonResponse
    {
        Size::query()->where('id',$id)->delete();
        return  $this->deletedResponse();
    }
}
