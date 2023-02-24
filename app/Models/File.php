<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
   const TABLE='files';

   const IMAGE='image';
   const VIDEO='video';
   const FILE_TYPES=[
     self::IMAGE,
     self::VIDEO
   ];


   protected $table=self::TABLE;

   protected $guarded=[];

}
