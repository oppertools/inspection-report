<?php

namespace App\Domain\InspectionReports\Jobs;

use App\Domain\InspectionReports\Data\InspectionReportData;
use App\Domain\InspectionReports\Mail\InspectionReportReadyMail;
use App\Domain\InspectionReports\ViewModels\InspectionReportViewModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class InspectionReportGenerationCompletedJob implements ShouldQueue
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
        $viewModel = new InspectionReportViewModel($this->inspectionReportData);

        Mail::to($viewModel->getRepresentative()->email)
            ->send(new InspectionReportReadyMail(
                $viewModel,
                $viewModel->getRepresentative()->firstName,
                $viewModel->property()->formatedAddress()
            ));
    }
}
