<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;
    const TABLE='inquiries';
    protected $table=self::TABLE;

    protected $guarded=[];

    protected $casts=[
      'read'=>'boolean'
    ];

    protected $attributes=[
      'read'=>false
    ];

}
