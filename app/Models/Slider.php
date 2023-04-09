<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    const TABLE='sliders';
    protected $table=self::TABLE;
    protected $guarded=[];
    protected $casts=[
        'value'=>'array'
    ];
}
