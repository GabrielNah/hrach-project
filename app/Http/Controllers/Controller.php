<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function successResponse(?array $data=[],?int $status=Response::HTTP_OK):JsonResponse
    {
        return response()->json(array_merge(['success'=>true],$data),$status);
    }

    public function createdResponse(?array $data=[]):JsonResponse
    {
        return $this->successResponse($data,Response::HTTP_CREATED);
    }

    public function deletedResponse():JsonResponse
    {
        return $this->successResponse([],Response::HTTP_NO_CONTENT);
    }


    public function errorResponse(?array $data=[]):JsonResponse
    {
        return $this->successResponse($data,Response::HTTP_BAD_REQUEST);
    }
}
