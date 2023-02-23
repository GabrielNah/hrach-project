<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    const TABLE='admins';
    protected $table=self::TABLE;

    protected $fillable=[
      'name','email','password'
    ];
    protected $hidden=['password'];


}
