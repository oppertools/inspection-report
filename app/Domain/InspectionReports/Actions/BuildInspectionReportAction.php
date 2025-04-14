<?php

namespace App\Domain\InspectionReports\Actions;

use App\Domain\InspectionReports\Data\InspectionReportData;
use App\Domain\InspectionReports\Jobs\DownloadPictureJob;
use App\Domain\InspectionReports\Jobs\ExtractSignaturesJob;
use App\Domain\InspectionReports\Jobs\InspectionReportGenerationCompletedJob;
use App\Domain\InspectionReports\Jobs\PdfGeneratorJob;
use App\Domain\InspectionReports\Jobs\PersistInspectionReportDetailsJob;
use App\Domain\InspectionReports\Jobs\PictureZipJob;
use App\Domain\InspectionReports\Jobs\QrCodeGeneratorJob;
use App\Domain\InspectionReports\Jobs\UploadFilesJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

readonly class BuildInspectionReportAction
{
    public function __construct(
        private InspectionReportData $data,
    ) {}

    public function handle(): void
    {
	    Log::info('Jobs chained');
        Bus::chain([
			new PersistInspectionReportDetailsJob($this->data),
            new DownloadPictureJob($this->data),
            new PictureZipJob($this->data->id),
            new QrCodeGeneratorJob($this->data->id),
            new ExtractSignaturesJob($this->data),
            new PdfGeneratorJob($this->data),
            new UploadFilesJob($this->data->id),
            new InspectionReportGenerationCompletedJob($this->data),
        ])->dispatch();

    }
}
