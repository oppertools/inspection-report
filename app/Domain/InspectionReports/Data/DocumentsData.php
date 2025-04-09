<?php

namespace App\Domain\InspectionReports\Data;

use Spatie\LaravelData\Data;

class DocumentsData extends Data
{
    public function __construct(
        public ?string $check_in_comparison_pdf,
        public ?string $inspection_report_pdf
    ) {}
}
