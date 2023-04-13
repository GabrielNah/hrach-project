<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use App\Models\SocialMedia;
use App\Services\FileService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactInfoController extends Controller
{

    public function __construct(private FileService $fileService)
    {
    }

    public function get():JsonResponse
    {
       $contactInfo=ContactInfo::query()->first();
       return $this->successResponse(compact('contactInfo'));
    }

    public function store(Request $request):JsonResponse
    {
        $request->validate([
           'new_settler_info'=>'required|string',
           'introduction'=>'required|string',
           'working_hours'=>'required|string',
           'address'=>'required|string',
           'email'=>'required|string|email',
           'phone'=>'required|string',
        ]);
        $contactInfo=ContactInfo::query()->firstOrNew();
        foreach ($request->all() as $key=>$value){
            $contactInfo->{$key}=$value;
        }
        $contactInfo->save();
        return $this->successResponse();
    }


    public function getSocialMedia():JsonResponse
    {
        $social=SocialMedia::all();
        return $this->successResponse(compact('social'));
    }

    public function storeSocialMedia(Request $request):JsonResponse
    {
        $request->validate([
           'link'=>'required|string|unique:'.SocialMedia::TABLE.',link' ,
            'img'=>'required|file|image'
        ]);
        $social=SocialMedia::query()->create([
            'link'=>$request->link,
            'img'=>'*'
        ]);
        $filePath='/public/socials/social_'.$social->id;
        $path=$this->fileService->storeFile($filePath,$request->file('img'));
        $social->img=$path;
        $social->save();
        return  $this->createdResponse(compact('social'));
    }

    public function editSocialMedia(Request $request,int $id):JsonResponse
    {
        $request->validate([
            'link'=>'string|unique:'.SocialMedia::TABLE.',link,'.$id ,
            'img'=>'file|image'
        ]);
        $social=SocialMedia::query()->find($id);
        if ($request->hasFile('img')){
            $filePath='/public/socials/social_'.$social->id;
            $path=$this->fileService->storeFile($filePath,$request->file('img'));
            $this->fileService->removeFile($social->img);
            $social->img=$path;
        }
        if ($request->has('link')){
            $social->link=$request->input('link');
        }
        $social->save();
        return $this->successResponse(compact('social'));

    }

    public function destroy(int $id):JsonResponse
    {
        $img=SocialMedia::query()->where('id',$id)->value('img');
        if ($img){
            $this->fileService->removeFile($img);
            SocialMedia::query()->where('id',$id)->delete();
            return $this->deletedResponse();
        }
        return $this->errorResponse(['e'=>'Not found']);

    }

}
