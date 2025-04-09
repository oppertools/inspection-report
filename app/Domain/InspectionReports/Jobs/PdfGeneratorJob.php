<?php

namespace App\Domain\InspectionReports\Jobs;

use App\Domain\InspectionReports\Data\InspectionReportData;
use App\Domain\InspectionReports\Models\InspectionReport;
use App\Domain\InspectionReports\Services\InspectionReportPdfGeneratorService;
use App\Domain\InspectionReports\ViewModels\InspectionReportViewModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class PdfGeneratorJob implements ShouldQueue
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
        $pdfGenerator = new InspectionReportPdfGeneratorService;
        $viewModel = new InspectionReportViewModel($this->inspectionReportData);

        $path = $pdfGenerator->generate(
            $viewModel
        );

        Cache::put("inspection:{$this->inspectionReportData->id}:pdf", $path);
    }
}
