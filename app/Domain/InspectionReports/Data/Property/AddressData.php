<?php

namespace App\Domain\InspectionReports\Data\Property;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class AddressData extends Data
{
    public function __construct(
        public ?string $city,
        public ?string $door,

        #[MapInputName('floor_number')]
        public ?int $floorNumber,

        #[MapInputName('line_1')]
        public ?string $line1,

        #[MapInputName('line_2')]
        public ?string $line2,

        #[MapInputName('postal_code')]
        public ?string $postalCode
    ) {}
}
