<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\EditColorRequest;
use App\Http\Requests\Admin\Settings\StoreColorRequest;
use App\Models\Color;
use App\Models\Size;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;

class SettingController extends Controller
{
    public function getSettings():JsonResponse
    {
        $colors=Color::query()->where('type',Color::TYPE_GLOBAL)->get();
        $sizes=Size::query()->where('type',Size::TYPE_GLOBAL)->get();
        $tags=Tag::all();
        return $this->successResponse(compact('sizes','colors','tags'));
    }
    /**
        Colors start
     **/
    public function storeColor(StoreColorRequest $request):JsonResponse
    {
        $color=Color::create(array_merge($request->validated(),['type'=>Color::TYPE_GLOBAL]));
        return $this->createdResponse(compact('color'));
    }

    public function editColor(int $id,EditColorRequest $request):JsonResponse
    {
        Color::where('id',$id)->update($request->validated());
        return $this->successResponse();
    }

    public function deleteColor(int $id):JsonResponse
    {
        $color=Color::find($id);
        $color->products()->detach();
        $color->delete();
        return $this->deletedResponse();
    }
    /**
        Colors end
     **/


    /**
        Sizes start
     **/
    public function storeSize(Request $request):JsonResponse
    {
        $validated=$request->validate([
            'size'=>'required|string|'.Rule::unique(Size::TABLE,'size')->where('type',Size::TYPE_GLOBAL)
        ]);
        $size=Size::query()->create(array_merge($validated,['type'=>Size::TYPE_GLOBAL]));
        return $this->successResponse(compact('size'));
    }


    public function editSize(int $id,Request $request):JsonResponse
    {
        $validated=$request->validate([
            'size'=>'required|string|'.Rule::unique(Size::TABLE,'size')->where('type',Size::TYPE_GLOBAL)->ignore($id)
        ]);
        Size::query()->where('id',$id)->update($validated);
        return  $this->successResponse();
    }

    public function removeSize(int $id):JsonResponse
    {
        $size=Size::find($id);
        $size->products()->detach();
        $size->delete();
        return  $this->deletedResponse();
    }
    /**
            Sizes end
     **/
    /**
            Tags start
     **/
    public function createTag(Request $request):JsonResponse
    {
        $validated=$request->validate([
           'name'=>'required|string|unique:tags,name',
           'description'=>'required|string',
        ]);

        $tag=Tag::query()->create($validated);

        return $this->createdResponse(compact('tag'));
    }

    public function editTag(Tag $tag,Request $request)
    {
        if (!$tag){
            return $this->errorResponse([
                'message'=>'Tag not found'
            ]);
        }
        $validated=$request->validate([
            'name'=>'required_without:description|string|unique:tags,name,'.$tag->id,
            'description'=>'required_without:name|string',
        ]);

        $tag=tap($tag,fn($tag)=>$tag->update($validated));
        return $this->successResponse(compact('tag'));
    }


    public function removeTag(int $id):JsonResponse
    {
       $tag= Tag::find($id);
       $tag->products()->detach();
       $tag->delete();
       return $this->deletedResponse();
    }
    /**
            Tag end
     **/







}
