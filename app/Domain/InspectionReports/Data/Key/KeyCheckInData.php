<?php

namespace App\Domain\InspectionReports\Data\Key;

use Spatie\LaravelData\Data;

class KeyCheckInData extends Data
{
    public function __construct(
        public ?int $count,
    ) {}
}
