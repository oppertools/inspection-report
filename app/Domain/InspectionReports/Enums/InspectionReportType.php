<?php

namespace App\Domain\InspectionReports\Enums;

use App\Support\Contracts\HasValues;

enum InspectionReportType: string implements HasValues
{
    case CHECK_IN = 'residential_lease_check_in';
    case CHECK_OUT = 'residential_lease_check_out';
    case UNKNOWN = 'unknown';

    public function label(): string
    {
        return match ($this) {
            self::CHECK_IN => "État des lieux d'entrée",
            self::CHECK_OUT => 'État des lieux de sortie',
            self::UNKNOWN => 'État des lieux'
        };
    }

    public static function tryFromOrUnknown(?string $value): self
    {
        if ($value === null) {
            return self::UNKNOWN;
        }

        return self::tryFrom($value) ?? self::UNKNOWN;
    }

	public static function values(): array
	{
		return array_column(self::cases(), 'value');
	}
}
