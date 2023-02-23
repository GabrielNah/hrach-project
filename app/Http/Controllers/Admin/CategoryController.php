<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpsertCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller
{
    public function index():JsonResponse
    {
        $categories=Category::query()->with('subCategories')->whereDoesntHave('parentCategory')->get();
        return $this->successResponse(compact('categories'));
    }

    public function store(?Category $category,UpsertCategoryRequest $request):JsonResponse
    {
        try {
            DB::beginTransaction();
            if ($category?->id){
                $category->update([
                    'name'=>$request->input('name'),
                    'hidden'=>$request->boolean('active')
                ]);
                if ($request->has('parent')){
                    SubCategory::query()
                        ->where('subcategory_id',$category->id)
                        ->update(['category_id'=>$request->input('parent')]);
                }
                DB::commit();
                return $this->successResponse();
            }
            $newCategory=Category::query()
                ->create([
                    'name'=>$request->input('name'),
                    'hidden'=>$request->boolean('active')
                ]);
            if ($request->has('parent')){
                SubCategory::query()->create([
                    'subcategory_id'=>$newCategory->id,
                    'category_id'=>$request->input('parent')
                ]);
            }
            DB::commit();
            return $this->successResponse();
        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json(['success'=>json_encode($e)],402);
        }

    }
}
