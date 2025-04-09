<?php

namespace App\Domain\InspectionReports\Enums;

enum KeyType: string
{
    case PRINCIPAL = 'principal';
    case PASS = 'pass';
    case CELLAR = 'cellar';
    case COMMON = 'common';
    case MAILBOX = 'mailbox';
    case GARAGE = 'garage';
    case PORTAL = 'portal';
    case BIKE_SHED = 'bike_shed';
    case BIN_STORAGE_AREA = 'bin_storage_area';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::PRINCIPAL => 'Porte Principale',
            self::PASS => 'Badge',
            self::CELLAR => 'Cave',
            self::COMMON => 'Parties communes',
            self::MAILBOX => 'Boîte aux lettres',
            self::GARAGE => 'Garage',
            self::PORTAL => 'Portail/Portillon',
            self::BIKE_SHED => 'Local à vélo',
            self::BIN_STORAGE_AREA => 'Local à ordures',
            self::OTHER => 'Autre',
        };
    }
}
