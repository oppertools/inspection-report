<?php

namespace App\Domain\InspectionReports\Enums\Room;

enum RoomElementCleanlinessState: string
{
    case CLEAN = 'clean';
    case TO_CLEAN = 'to_clean';

    public function label(): string
    {
        return match ($this) {
            self::CLEAN => 'Propre',
            self::TO_CLEAN => 'À nettoyer',
        };
    }

    public function color()
    {
        return match ($this) {
            self::CLEAN => 'blue',
            self::TO_CLEAN => 'red',
        };
    }
}
