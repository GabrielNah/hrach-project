<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSettings extends Model
{
    use HasFactory;
    const TABLE='home_page_settings';
    protected $table=self::TABLE;
    protected $guarded=[];
    public $timestamps=false;
    protected $casts=[
      'main'=>'boolean'
    ];
}
