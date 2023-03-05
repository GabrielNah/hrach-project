<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    const TABLE='tags';
    protected $guarded=[];
    public $timestamps=false;

    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class,'product_tag','tag_id','product_id');
    }
}
