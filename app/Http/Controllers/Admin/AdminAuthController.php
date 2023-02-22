<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if ($this->auth()->attempt($request->validated())){
            $request->session()->regenerate();
            return $this->successResponse([
                'user'=>$this->auth()->user()
            ]);
        }
        throw ValidationException::withMessages([
            'credentials'=>'Provided credentials are incorrect'
        ]);
    }


    public function logout(Request $request)
    {
        $this->auth()->logout();
        $request->session()->invalidate();
        return $this->successResponse();
    }

    public function getAdmin(): \Symfony\Component\HttpFoundation\JsonResponse
    {
        return $this->successResponse([
            'admin'=>$this->auth()->user()??null
        ]);
    }



    private function auth(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return  Auth::guard('admin');
    }
}
