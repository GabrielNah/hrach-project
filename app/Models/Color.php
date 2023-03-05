<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    const TABLE='colors';
    protected $table=self::TABLE;
    protected $guarded=[];
    public $timestamps=false;

    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class,'product_color','color_id','product_id');
    }


}
