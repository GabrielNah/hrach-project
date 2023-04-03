<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    const TABLE='currency_rates';
    protected $table=self::TABLE;
    protected $guarded=[];
    public $timestamps=false;
    const MAIN_CURRENCY='USD';

}
