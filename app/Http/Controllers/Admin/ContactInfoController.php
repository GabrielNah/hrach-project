<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactInfoController extends Controller
{
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

}
