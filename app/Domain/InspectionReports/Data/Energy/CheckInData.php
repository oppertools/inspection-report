<?php

namespace App\Domain\InspectionReports\Data\Energy;

class CheckInData
{
    public function __construct(
        public int $index_1,
        public int $index_2,
    ) {}
}
