<?php

namespace App\Domain\InspectionReports\Data;

use App\Domain\InspectionReports\Casts\InspectionReportTypeCast;
use App\Domain\InspectionReports\Casts\SmartDateCast;
use App\Domain\InspectionReports\Data\Key\KeyData;
use App\Domain\InspectionReports\Data\Property\PropertyData;
use App\Domain\InspectionReports\Data\Room\RoomData;
use App\Domain\InspectionReports\Enums\InspectionReportType;
use App\Domain\InspectionReports\Transformers\InspectionReportTypeTransformer;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class InspectionReportData extends Data
{
    public function __construct(
        public readonly string $id,

        #[WithTransformer(InspectionReportTypeTransformer::class)]
        #[WithCast(InspectionReportTypeCast::class)]
        public readonly ?InspectionReportType $type,

        #[MapInputName('check_in_date')]
        #[WithCast(SmartDateCast::class)]
        public readonly ?Carbon $checkInDate,

        public readonly ?DocumentsData $documents,

        #[MapInputName('date')]
        #[WithCast(SmartDateCast::class)]
        public readonly ?Carbon $finalizedAt,

        public readonly ?CleanlinessData $cleanliness = null,
        public readonly ?ObservationsData $observations = null,
        public readonly ?PropertyData $property = null,

        /** @var DataCollection<KeyData>|null */
        public readonly ?DataCollection $keys = null,

        /** @var DataCollection<MeterData>|null */
        public readonly ?DataCollection $meters = null,

        /** @var DataCollection<PictureData> */
        public readonly ?DataCollection $pictures = null,

        /** @var DataCollection<RoomData> */
        public readonly ?DataCollection $rooms = null,

        /** @var DataCollection<SignatoryData> */
        public readonly ?DataCollection $signatories = null,
    ) {}
}
