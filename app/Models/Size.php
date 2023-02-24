<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    const TABLE='sizes';
    protected $table=self::TABLE;

    public $timestamps=false;
    protected $guarded=[];
}
