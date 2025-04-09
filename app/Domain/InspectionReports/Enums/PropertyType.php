<?php

namespace App\Domain\InspectionReports\Enums;

enum PropertyType: string
{
    case FLAT = 'flat';
    case HOUSE = 'house';
    case BOX = 'box';
    case PARKING = 'parking';
    case BUSINESS_PREMISE = 'business_premise';
    case OFFICE = 'office';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::FLAT => 'Appartement',
            self::HOUSE => 'Maison',
            self::BOX => 'Box',
            self::PARKING => 'Parking',
            self::BUSINESS_PREMISE => 'Local commercial',
            self::OFFICE => 'Bureau',
            self::OTHER => 'Autre',
        };
    }
}
