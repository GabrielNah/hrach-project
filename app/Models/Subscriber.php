<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    const TABLE='subscribers';
    protected $table=self::TABLE;
    public $timestamps=false;

    protected $guarded=[];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->subscribed_at = now();
        });
    }
}
