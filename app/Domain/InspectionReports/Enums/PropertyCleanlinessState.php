<?php

namespace App\Domain\InspectionReports\Enums;

enum PropertyCleanlinessState: string
{
    case EXCELLENT = 'excellent';
    case GOOD = 'good';
    case AVERAGE = 'average';
    case BAD = 'bad';

    public function label(): string
    {
        return match ($this) {
            self::EXCELLENT => 'Très propre',
            self::GOOD => 'Satisfaisant',
            self::AVERAGE => 'Moyen',
            self::BAD => 'Non nettoyé'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::EXCELLENT => 'blue',
            self::GOOD => 'green',
            self::AVERAGE => 'orange',
            self::BAD => 'red'
        };
    }
}
