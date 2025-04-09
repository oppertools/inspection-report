<?php

namespace App\Domain\InspectionReports\Transformers;

use App\Domain\InspectionReports\Enums\InspectionReportType;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Support\Transformation\TransformationContext;
use Spatie\LaravelData\Transformers\Transformer;

class InspectionReportTypeTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value) && ! InspectionReportType::tryFrom($value)) {
            return InspectionReportType::UNKNOWN->value;
        }

        return $value;
    }
}
