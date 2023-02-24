<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    const TABLE='products';
    protected $table=self::TABLE;

    protected $guarded=[];

    protected $casts=[
        'active'=>'boolean'
    ];

    public function files():HasMany
    {
        return  $this->hasMany(File::class,'product_id','id');
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class,'id','category_id');
    }

    public function prices():HasMany
    {
        return $this->hasMany(Price::class,'product_id','id');
    }

}
