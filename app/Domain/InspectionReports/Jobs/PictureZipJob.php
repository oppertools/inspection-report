<?php

namespace App\Domain\InspectionReports\Jobs;

use App\Domain\InspectionReports\Models\InspectionReport;
use App\Domain\InspectionReports\Services\PictureZipService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class PictureZipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $inspectionReportId;

    public function __construct(string $inspectionReportId)
    {
        $this->inspectionReportId = $inspectionReportId;
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $pictureZip = new PictureZipService;
        $cache = Cache::get("inspection:{$this->inspectionReportId}:pictures");

        $path = $pictureZip->createZip(
            $cache,
	        "edl-{$this->inspectionReportId}.zip",
            $this->inspectionReportId,
	        'zipName'
        );

	    Cache::put("inspection:{$this->inspectionReportId}:zip", $path);
    }
}
