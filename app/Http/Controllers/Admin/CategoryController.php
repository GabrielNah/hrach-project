<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpsertCategoryRequest;
use App\Models\Category;
use App\Services\CategoryRepasitory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(private CategoryRepasitory $categoryRepasitory)
    {

    }

    public function index():JsonResponse
    {
        $categories=$this->categoryRepasitory->getCategoriesWithSubCategories();
        return $this->successResponse(compact('categories'));
    }

    public function store(?Category $category,UpsertCategoryRequest $request):JsonResponse
    {
        try {
            DB::beginTransaction();
            if ($category?->id){
                $this->categoryRepasitory->updateCategory(
                    $category,
                    $request->input('name'),
                    $request->boolean('active'),
                    $request->input('parent')
                );
                DB::commit();
                return $this->successResponse();
            }
            $this->categoryRepasitory->createCategoryWithSubCategory(
                $request->input('name'),
                $request->boolean('active'),
                $request->input('parent')
            );
            DB::commit();
            return $this->successResponse();
        }catch (\Throwable $e){
            DB::rollBack();
            return $this->errorResponse(['msg'=>'Something went wrong,refresh page and and try again']);
        }

    }


    public function delete(Category $category)
    {
        $success=$this->categoryRepasitory->removeCategory($category);
        if ($success){
            return $this->deletedResponse();
        }
        return $this->errorResponse(['msg'=>'Something went wrong,refresh page and and try again']);
    }

    public function makeCategoriesShowable(Request $request):JsonResponse
    {
        $request->validate([
            'ids'=>'array|required|min:1',
            'ids.*'=>'required|integer|exists:categories,id'
        ]);
        $this->categoryRepasitory->makeShowable($request->input('ids'));
        return $this->successResponse();

    }
}
