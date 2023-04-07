<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    const TABLE='comments';
    protected $table=self::TABLE;
    protected $guarded=[];
}
