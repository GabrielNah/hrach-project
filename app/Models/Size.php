<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Size extends Model
{
    const TABLE='sizes';

    const TYPE_INDIVIDUAL = 'individual';
    const TYPE_GLOBAL     = 'global';
    const TYPES=[
        self::TYPE_GLOBAL,
        self::TYPE_INDIVIDUAL,
    ];
    protected $table=self::TABLE;

    public $timestamps=false;
    protected $guarded=[];


    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class,'product_size','size_id','product_id');
    }
}
