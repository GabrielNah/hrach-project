<?php

namespace App\Traits;

use App\Models\Color;
use App\Models\Size;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasColorsAndSizes
{
    public function colors():BelongsToMany
    {
        return $this->belongsToMany(Color::class,'product_color','product_id','color_id');
    }

    public function sizes():BelongsToMany
    {
        return $this->belongsToMany(Size::class,'product_size','product_id','size_id');
    }
}
