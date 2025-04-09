<?php

namespace App\Domain\InspectionReports\Data\Energy;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class EnergyData extends Data
{
    public function __construct(

        #[MapInputName('heating_source')]
        public ?HeatingSourceData $heatingSource,

        #[MapInputName('hot_water_source')]
        public ?HotWaterSourceData $hotWaterSource,
    ) {}
}
