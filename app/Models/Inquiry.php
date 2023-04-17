<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function product():HasOne
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

}
