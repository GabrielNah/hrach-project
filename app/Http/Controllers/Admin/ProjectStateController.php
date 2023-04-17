<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HomePageSettings\EditSiteAppearanceRequest;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\SiteAppearance;
use App\Models\Subscriber;
use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectStateController extends Controller
{
    public function unreadInquiryExists():JsonResponse
    {
        return $this->successResponse([
           'unreadInquiryExists'=>Inquiry::query()->where('read',false)->exists()
        ]);
    }

    public function projectState(): JsonResponse
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


    public function siteAppearance():JsonResponse
    {
        $sections=SiteAppearance::all();
        return $this->successResponse(compact('sections'));
    }

    public function editAppearance(EditSiteAppearanceRequest $request,int $id):JsonResponse
    {
        $section=SiteAppearance::query()->firstOrNew(compact('id'));
        $section->section=$request->input('section');
        $section->type=$request->input('type');
        $val=$request->input('value');
        if ($request->hasFile('value')){
            $val=(new FileService)->storeFile(
                'public/SiteAppearance/'.$section['section'],
                $request->file('value')
            );
        }
        $section->value=$val;
        $section->save();
        return $this->successResponse(compact('section'));
    }



}
