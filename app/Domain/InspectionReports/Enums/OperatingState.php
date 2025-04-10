<?php

namespace App\Domain\InspectionReports\Enums;

enum OperatingState: string
{
    case WORKING = 'working';
    case NOT_WORKING = 'not_working';
    case NOT_TESTED = 'not_tested';
    case UNABLE_TO_TEST = 'unable_to_test';
    case MISSING = 'missing';
	case UNKNOW = 'unknow';

    public function label(): string
    {
        return match ($this) {
            self::WORKING => 'Testé, fonctionnel',
            self::NOT_WORKING => 'Testé, non fonctionnel',
            self::NOT_TESTED => 'Non testé',
            self::UNABLE_TO_TEST => 'Non testable',
            self::MISSING => 'Absent',
	        self::UNKNOW => 'Non communiqué',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::WORKING => 'check',
            self::NOT_WORKING => 'x',
            self::NOT_TESTED => 'circle-minus',
            self::UNABLE_TO_TEST => 'ban',
            self::MISSING => 'x',
            self::UNKNOW => 'x',
        };
    }

	public static function tryFromOrDefault(string|null $value): self
	{
		return self::tryFrom($value) ?? self::UNKNOW;
	}

    public function color(): string
    {
        return match ($this) {
            self::WORKING => 'green',
            self::NOT_WORKING => 'red',
            self::NOT_TESTED => 'gray',
            self::UNABLE_TO_TEST => 'orange',
            self::MISSING => 'purple',
            self::UNKNOW => 'gray',
        };
    }
}
