<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    const TABLE='sub_categories';
    protected $table=self::TABLE;
    protected $fillable=[
        'category_id','subcategory_id'
    ];

    public $timestamps=false;
}
