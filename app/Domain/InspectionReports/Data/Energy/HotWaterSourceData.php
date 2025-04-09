<?php

namespace App\Domain\InspectionReports\Data\Energy;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class HotWaterSourceData extends Data
{
    public function __construct(
        #[MapInputName('is_district_hot_water')]
        public ?bool $isDistrictHotWater,

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
