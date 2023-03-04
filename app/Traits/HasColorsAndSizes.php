<?php

namespace App\Traits;

use App\Models\Color;
use App\Models\Size;
use Illuminate\Database\Eloquent\Collection;

trait HasColorsAndSizes
{
    public function getColors():Collection
    {
        return Color::query()->whereIn('id',$this->colors)->get();
    }

    public function getSizes():Collection
    {
        return Size::query()->whereIn('id',$this->sizes)->get();
    }
}
