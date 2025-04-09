<?php

namespace App\Domain\InspectionReports\Enums;

enum Condition: string
{
    case EXCELLENT = 'excellent';
    case GOOD = 'good';
    case USED = 'used';
    case POOR = 'poor';
    case MISSING = 'missing';

    public function label(): string
    {
        return match ($this) {
            self::EXCELLENT => 'Neuf',
            self::GOOD => 'Bon',
            self::USED => 'Moyen',
            self::POOR => 'Mauvais',
            self::MISSING => 'Manquant',
        };
    }
}
