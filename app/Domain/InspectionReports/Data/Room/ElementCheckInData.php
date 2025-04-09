<?php

namespace App\Domain\InspectionReports\Data\Room;

use App\Domain\InspectionReports\Enums\Condition;
use Spatie\LaravelData\Data;

class ElementCheckInData extends Data
{
    public function __construct(
        public ?Condition $condition,
        public ?int $count
    ) {}
}
