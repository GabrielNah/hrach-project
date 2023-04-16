<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteAppearance extends Model
{
    use HasFactory;
    const TABLE='site_appearance';
    protected $table=self::TABLE;
    protected $guarded=[];
    public $timestamps=false;
}
