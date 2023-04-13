<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    const TABLE='subscribers';
    protected $table=self::TABLE;

    protected $guarded=[];
    public $timestamps=false;
}
