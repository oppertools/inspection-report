<?php

namespace App\Domain\InspectionReports\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use App\Domain\InspectionReports\Enums\OperatingState;

class OperatingStateCast implements Cast
{
	public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): OperatingState
	{
		return OperatingState::tryFrom($value) ?? OperatingState::UNKNOW;
	}
}
