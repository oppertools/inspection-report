<?php

namespace App\Domain\InspectionReports\Data\Property;

use App\Domain\InspectionReports\Data\Energy\EnergyData;
use App\Domain\InspectionReports\Enums\PropertyType;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class PropertyData extends Data
{
    public function __construct(
        public ?AddressData $address,
        public ?EnergyData $energy,
        public ?FeaturesData $features,

        public ?bool $furnished,
        public ?string $reference,

        #[MapInputName('rooms_count')]
        public ?int $roomsCount,

        #[MapInputName('surface_area')]
        public ?float $surfaceArea,

        public ?PropertyType $type,
    ) {}
}
