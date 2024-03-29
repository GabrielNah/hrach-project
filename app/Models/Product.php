<?php

namespace App\Models;

use App\Traits\HasColorsAndSizes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class Product extends Model
{
    use HasColorsAndSizes;
    const TABLE='products';
    protected $table=self::TABLE;

    protected $guarded=[];

    protected $casts=[
        'active'=>'boolean',
        'in_stock'=>'boolean',
    ];

    protected $attributes=[
        'in_stock'=>false
    ];

    public function files():HasMany
    {
        return  $this->hasMany(File::class,'product_id','id');
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function prices():HasMany
    {
        return $this->hasMany(Price::class,'product_id','id');
    }

    public function priceForOne():HasOne
    {
        return $this->hasOne(Price::class,'product_id','id')
            ->where('min_count',1)->where('max_count',1);
    }

    public function additional():HasOne
    {
        return $this->hasOne(ProductAdditional::class,'product_id','id');
    }

    public function generalFile():HasOne
    {
        return  $this->hasOne(File::class,'product_id','id')
            ->where('general','1');
    }


    public function nonGeneralFiles():HasMany
    {
        return  $this->hasMany(File::class,'product_id','id')
                    ->where('general','0');
    }

    public function tags():BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'product_tag','product_id','tag_id');
    }

    public function sizes():BelongsToMany
    {
        return $this->belongsToMany(Size::class,'product_size','product_id','size_id');
    }

    public function colors():BelongsToMany
    {
        return $this->belongsToMany(Color::class,'product_color','product_id','color_id');
    }

    public function comments():HasMany
    {
        return  $this->hasMany(Comment::class,'product_id','id');
    }

}
