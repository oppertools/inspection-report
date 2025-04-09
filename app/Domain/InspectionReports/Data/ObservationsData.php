<?php

namespace App\Domain\InspectionReports\Data;

use Spatie\LaravelData\Data;

class ObservationsData extends Data
{
    public function __construct(
        public ?string $owner = 'Aucune observation ni réserve.',
        public ?string $tenant = 'Aucune observation ni réserve.'
    ) {}
}
