<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\UpsertRatesRequest;
use App\Models\CurrencyRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class CurrencyRateController extends Controller
{
    public function index():JsonResponse
    {
        $currency_rates = CurrencyRate::all();
        return $this->successResponse(compact('currency_rates'));
    }


    public function store(UpsertRatesRequest $request):JsonResponse
    {
        try {
            DB::beginTransaction();
                CurrencyRate::query()->delete();
                collect($request->input('data'))->each(function ($currency){
                    CurrencyRate::query()->create([
                        'currency'=>$currency['currency'],
                        'rate'=>$currency['rate'],
                    ]);
                });
            DB::commit();
            return $this->successResponse();
        }catch (\Throwable $exception){
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            return $this->errorResponse(['e'=>$exception->getMessage()]);
        }
    }
}
