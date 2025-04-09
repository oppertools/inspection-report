<?php

namespace App\Domain\InspectionReports\Data\Energy;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class HeatingSourceData extends Data
{
    public function __construct(
        #[MapInputName('is_air_conditioning')]
        public ?bool $isAirConditioning,

        #[MapInputName('is_district_heating')]
        public ?bool $isDistrictHeating,

        #[MapInputName('is_electric')]
        public ?bool $isElectric,

        #[MapInputName('is_gas')]
        public ?bool $isGas,

        #[MapInputName('is_oil')]
        public ?bool $isOil,

        #[MapInputName('is_other')]
        public ?bool $isOther
    ) {}
}
