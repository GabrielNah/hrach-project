<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const TABLE='categories';
    protected $table=self::TABLE;
    protected $fillable=[
        'name','active'
    ];

    protected $casts=[
        'active'=>'boolean'
    ];
}
