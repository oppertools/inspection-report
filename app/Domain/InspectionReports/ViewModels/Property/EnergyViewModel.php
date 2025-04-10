<?php

namespace App\Domain\InspectionReports\ViewModels\Property;

use App\Domain\InspectionReports\Data\Energy\EnergyData;
use Spatie\ViewModels\ViewModel;

class EnergyViewModel extends ViewModel
{
    private const NO_HEATING = 'Pas de chauffage';

    private const NO_HOT_WATER = "Pas d'eau chaude";

    public function __construct(
        private readonly ?EnergyData $energy,
    ) {}

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }

        return null;
    }

    public function heatingSource(): ?string
    {
        if (! $this->energy || ! $this->energy->heatingSource) {
            return 'Non communiqué';
        }

        $source = $this->energy->heatingSource;

        if ($this->hasNoSource($source, true)) {
            return self::NO_HEATING;
        }

        $type = $source->isDistrictHeating ? 'Collectif' : 'Individuel';

        return $this->formatWithEnergySource($type, $source);
    }

    public function hotWaterSource(): ?string
    {
        if (! $this->energy || ! $this->energy->hotWaterSource) {
            return 'Non communiqué';
        }

        $source = $this->energy->hotWaterSource;

        if ($this->hasNoSource($source, false)) {
            return self::NO_HOT_WATER;
        }

        $type = $source->isDistrictHotWater ? 'Collective' : 'Individuelle';

        return $this->formatWithEnergySource($type, $source);
    }

    private function hasNoSource(object $source, bool $isHeating): bool
    {
        $conditions = [
            ! $source->isElectric,
            ! $source->isGas,
            ! $source->isOil,
            ! $source->isOther,
        ];

        if ($isHeating) {
            $conditions[] = ! $source->isDistrictHeating;
            $conditions[] = ! $source->isAirConditioning;
        } else {
            $conditions[] = ! $source->isDistrictHotWater;
        }

        return ! in_array(false, $conditions);
    }

    private function formatWithEnergySource(string $type, object $source): string
    {
        $energySource = null;

        switch (true) {
            case $source->isElectric:
                $energySource = 'Électrique';
                break;
            case $source->isGas:
                $energySource = 'Gaz';
                break;
            case $source->isOil:
                $energySource = 'Fioul';
                break;
            case isset($source->isAirConditioning) && $source->isAirConditioning:
                $energySource = 'Climatisation réversible';
                break;
            case $source->isOther:
                $energySource = 'Autre';
                break;
        }

        return $energySource ? "$energySource ($type)" : $energySource ?? 'Non communiqué';
    }
}
