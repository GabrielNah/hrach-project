<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAdditional extends Model
{
    const TABLE="prices_additional";
    protected $table=self::TABLE;
    protected $guarded=[];
    protected $casts=[
        'additional'=>'array',
        'size'      =>'array'
    ];
}
