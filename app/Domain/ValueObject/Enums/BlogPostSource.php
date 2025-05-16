<?php

namespace App\Domain\ValueObject\Enums;

enum BlogPostSource: string
{
    case App = 'app';
    case Api = 'api';
}
