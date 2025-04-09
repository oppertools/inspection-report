<?php

namespace App\Domain\InspectionReports\Events;

use App\Domain\InspectionReports\Mail\InspectionReportReadyMail;
use App\Domain\InspectionReports\ViewModels\InspectionReportViewModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class InspectionReportGenerationCompletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public InspectionReportViewModel $viewModel;

    /**
     * Create a new event instance.
     */
    public function __construct(InspectionReportViewModel $viewModel)
    {
        $this->viewModel = $viewModel;

        Mail::to($viewModel->getRepresentative()->email)
            ->send(new InspectionReportReadyMail($viewModel, $viewModel->getRepresentative()));

    }
}
