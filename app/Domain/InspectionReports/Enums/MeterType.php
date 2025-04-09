<?php

namespace App\Domain\InspectionReports\Enums;

enum MeterType: string
{
    case WATER = 'water';
    case ELECTRICITY = 'electricity';
    case GAS = 'gas';
    case THERMAL_ENERGY = 'thermal_energy';

    public function label(): string
    {
        return match ($this) {
            self::WATER => 'Eau',
            self::ELECTRICITY => 'Électricité',
            self::GAS => 'Gaz',
            self::THERMAL_ENERGY => 'Énergie thermique',
        };
    }
}
