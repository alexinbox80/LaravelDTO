<?php

namespace App\Domain\ValueObject\Enums;

enum Metric: string
{
    case CACHE_HIT = 'cache_hit';
    case CACHE_MISS = 'cache_miss';
}
