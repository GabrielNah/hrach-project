<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotKey extends Model
{
    use HasFactory;
    const TABLE='hot_keys';
    protected $table=self::TABLE;
    protected $guarded=[];
    public $timestamps=false;
}
