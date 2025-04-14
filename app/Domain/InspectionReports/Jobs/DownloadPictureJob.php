<?php

namespace App\Domain\InspectionReports\Jobs;

use App\Domain\InspectionReports\Data\InspectionReportData;
use App\Domain\InspectionReports\Services\PictureDownloaderService;
use App\Domain\InspectionReports\ViewModels\InspectionReportViewModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DownloadPictureJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public InspectionReportData $inspectionReportData;

    public function __construct(InspectionReportData $inspectionReportData)
    {
        $this->inspectionReportData = $inspectionReportData;
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
	    Log::info('Pictures downloading started');
        $pictureDownloader = new PictureDownloaderService;
        $viewModel = new InspectionReportViewModel($this->inspectionReportData);

        $path = $pictureDownloader->downloadPictures(
            $viewModel->picturesWithIndex(),
            $this->inspectionReportData
        );

        Cache::put("inspection:{$this->inspectionReportData->id}:pictures", $path);
    }
}
