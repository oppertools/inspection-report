<?php

namespace App\Domain\InspectionReports\Data\Room;

class Color
{
    public function __construct(
        public string $name,
        public string $hex
    ) {}
}
