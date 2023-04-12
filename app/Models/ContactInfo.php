<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    const TABLE='contact_info';
    protected $table=self::TABLE;
    protected $guarded=[];
    public $timestamps=false;
}
