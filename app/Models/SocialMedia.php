<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    const TABLE='social_medias';
    protected $table=self::TABLE;
    protected $guarded=[];
    public $timestamps=false;

}
