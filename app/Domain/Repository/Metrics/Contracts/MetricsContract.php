<?php

namespace App\Domain\Repository\Metrics\Contracts;

use App\Domain\Models\BlogPostModel;
use App\Domain\ValueObject\Enums\Metric;
use Illuminate\Database\Eloquent\Collection;

interface MetricsContract
{
    public function readLastNumericValue(Metric $metric): int|float|null;

    public function writeNumericValue(Metric $metric, int|float $value, array $tags = [], ?float $time = null): void;
}
