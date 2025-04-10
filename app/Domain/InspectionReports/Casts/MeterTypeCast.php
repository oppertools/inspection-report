<?php

namespace App\Domain\InspectionReports\Casts;

use App\Domain\InspectionReports\Enums\KeyType;
use App\Domain\InspectionReports\Enums\MeterType;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use App\Domain\InspectionReports\Enums\OperatingState;

class MeterTypeCast implements Cast
{
	public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): MeterType
	{
		return MeterType::tryFrom($value) ?? MeterType::OTHER;
	}
}
