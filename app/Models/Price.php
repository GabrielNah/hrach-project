<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    const TABLE='prices';
    protected $table=self::TABLE;
    protected $guarded=[];
    const RUB='RUB';
    const USD='USD';
    const EUR='EUR';

    const CURRENCIES=[
        self::EUR,
        self::RUB,
        self::USD
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class,'id','product_id');
    }
}
