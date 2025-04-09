<?php

namespace App\Domain\InspectionReports\Casts;

use App\Domain\InspectionReports\Enums\InspectionReportType;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class InspectionReportTypeCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): ?InspectionReportType
    {
        if ($value === null) {
            return null;
        }

        try {
            return InspectionReportType::from($value);
        } catch (\ValueError $e) {
            return InspectionReportType::UNKNOWN;
        }
    }
}
