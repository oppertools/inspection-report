<?php

namespace App\Domain\InspectionReports\Data;

use App\Domain\InspectionReports\Enums\PropertyCleanlinessState;
use Spatie\LaravelData\Data;

class CleanlinessData extends Data
{
    public function __construct(
        public ?PropertyCleanlinessState $state = null
    ) {}
}
