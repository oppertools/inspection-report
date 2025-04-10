<?php

namespace App\Domain\InspectionReports\Casts;

use App\Domain\InspectionReports\Enums\KeyType;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;
use App\Domain\InspectionReports\Enums\OperatingState;

class KeyTypeCast implements Cast
{
	public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): KeyType
	{
		return KeyType::tryFrom($value) ?? KeyType::OTHER;
	}
}
