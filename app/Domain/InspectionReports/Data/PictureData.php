<?php

namespace App\Domain\InspectionReports\Data;

use App\Domain\InspectionReports\Casts\SmartDateCast;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class PictureData extends Data
{
    public function __construct(
        public ?string $id,
        public ?string $url,
        public ?string $number,

        #[MapInputName('created_at')]
        #[WithCast(SmartDateCast::class)]
        public ?Carbon $createdAt,

    ) {}
}
