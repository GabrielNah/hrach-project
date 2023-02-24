<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    const TABLE='colors';
    protected $table=self::TABLE;
    protected $guarded=[];
    public $timestamps=false;

}
