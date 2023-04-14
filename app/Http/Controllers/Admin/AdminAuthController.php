<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\ChangeCredentialsRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminAuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
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


    public function logout(Request $request): JsonResponse
    {
        $this->auth()->logout();
        $request->session()->invalidate();
        return $this->successResponse();
    }

    public function getAdmin(): JsonResponse
    {
        return $this->successResponse([
            'admin'=>$this->auth()->user()??null
        ]);
    }



    private function auth(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return  Auth::guard('admin');
    }

    public function changeCredentials(ChangeCredentialsRequest $request):JsonResponse
    {
        $admin=Admin::query()->first();
        if ($request->has('name')){
            $admin->name=$request->input('name');
        }
        if ($request->has('email')){
            $admin->email=$request->input('email');
        }
        if ($request->has('current_password')){
            if (!Hash::check($request->input('current_password'),$admin->password)){
                throw  ValidationException::withMessages(['current_password'=>'Provided password is incorrect']);
            }
            if ($request->has('new_password')){
                $admin->password=Hash::make($request->input('new_password'));
            }
        }
        $admin->save();
        return $this->successResponse([
            'admin'=>$admin
        ]);

    }

}
