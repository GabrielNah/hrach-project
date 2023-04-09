<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Category extends Model
{
    const TABLE='categories';
    protected $table=self::TABLE;
    protected $fillable=[
        'name','active','in_header'
    ];

    protected $casts=[
        'active'=>'boolean',
        'in_header'=>'boolean'
    ];

    public function subCategories():HasManyThrough
    {
        return  $this->hasManyThrough(self::class,SubCategory::class,'category_id','id','id','subcategory_id');
    }

    public function parentCategory():HasOneThrough
    {
        return  $this->hasOneThrough(self::class,SubCategory::class,'subcategory_id','id','id','category_id');
    }


    public function products():HasMany
    {
        return  $this->hasMany(Product::class,'category_id','id');
    }
}
