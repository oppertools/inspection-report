<?php

namespace App\Domain\InspectionReports\Enums\Signatory;

enum SignatoryType: string
{
    case OWNER = 'owner';
    case TENANT = 'tenant';
    case REPRESENTATIVE = 'representative';

    public function label(): string
    {
        return match ($this) {
            self::OWNER => 'Propriétaire',
            self::TENANT => 'Locataire',
            self::REPRESENTATIVE => 'Mandataire',
        };
    }
}
