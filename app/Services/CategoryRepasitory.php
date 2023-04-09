<?php

namespace App\Services;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryRepasitory
{

    public function getCategoriesWithSubCategories():Collection
    {
        return Category::query()->with('subCategories')->whereDoesntHave('parentCategory')->get();
    }

    public function createCategoryWithSubCategory(string $name,bool $active,?int $subcategory_id=0):void
    {
        $newCategory=Category::query()
            ->create([
                'name'=>$name,
                'active'=>$active?'1':'0'
            ]);
        if ($subcategory_id){
            SubCategory::query()->create([
                'subcategory_id'=>$newCategory->id,
                'category_id'=>$subcategory_id
            ]);
        }
    }


    public function updateCategory(Category $category,string $name,bool $active,?int $parent=0)
    {
        $category->update([
            'name'=>$name,
            'active'=>$active?'1':'0'
        ]);
        if ($parent){
            SubCategory::query()
                ->where('subcategory_id',$category->id)
                ->update(['category_id'=>$parent]);
        }
    }


    public function removeCategory(Category $category):bool
    {
        try {
            DB::beginTransaction();
                    $category->subCategories()->delete();
                    SubCategory::query()
                        ->where('subcategory_id',$category->id)
                        ->orWhere('category_id',$category->id)
                        ->delete();
                    $category->delete();
            DB::commit();
            return true;
        }catch (\Throwable $e){
            DB::rollBack();
            Log::error(json_encode($e,JSON_PRETTY_PRINT));
            return false;
        }
    }

    public function makeShowable(array $ids):void
    {
        Category::query()
            ->whereIn('id',$ids)
            ->update(['in_header'=>true]);

    }
}
