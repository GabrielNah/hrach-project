<?php

namespace App\Services\Enums;

enum SEARCH_TYPES:string
{
    case DEFAULT='default';
    case IDS='ids';
    case CATEGORY='category';
    case FILTER='filter';
}
