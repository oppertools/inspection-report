<?php

namespace App\Domain\InspectionReports\Data\Property;

use App\Domain\InspectionReports\Casts\OperatingStateCast;
use App\Domain\InspectionReports\Enums\OperatingState;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class FeaturesData extends Data
{
    public function __construct(
        #[MapInputName('smoke_detector')]
        #[WithCast(OperatingStateCast::class)]
        public ?OperatingState $smokeDetectorCondition = null
    ) {}
}
