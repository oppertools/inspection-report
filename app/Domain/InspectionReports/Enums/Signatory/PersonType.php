<?php

namespace App\Domain\InspectionReports\Enums\Signatory;

enum PersonType: string
{
    case NATURAL = 'natural_person';
    case LEGAL = 'legal_person';

    public function label(): string
    {
        return match ($this) {
            self::NATURAL => 'Personne physique',
            self::LEGAL => 'Personne morale',
        };
    }
}
