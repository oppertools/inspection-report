<?php

namespace App\Domain\InspectionReports\Jobs;

use App\Domain\InspectionReports\Models\InspectionReport;
use App\Domain\InspectionReports\Services\GenerateQrCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class QrCodeGeneratorJob implements ShouldQueue
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
        $qrCode = new GenerateQrCode;

        $path = $qrCode->generate($this->inspectionReportId);

        Cache::put("inspection:{$this->inspectionReportId}:qrcode", $path);
    }
}
