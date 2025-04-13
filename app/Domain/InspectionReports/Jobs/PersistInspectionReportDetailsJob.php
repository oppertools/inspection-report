<?php

namespace App\Domain\InspectionReports\Jobs;

use App\Domain\InspectionReports\Data\InspectionReportData;
use App\Domain\InspectionReports\Models\InspectionReport;
use App\Domain\InspectionReports\ViewModels\InspectionReportViewModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PersistInspectionReportDetailsJob implements ShouldQueue
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
    public function handle(): InspectionReport
    {
        $viewModel = new InspectionReportViewModel($this->inspectionReportData);
        $storagePath = "inspection-report/{$viewModel->id}/";
        $finalizedAt = $viewModel->finalizedAt;

		$inspectionReport = InspectionReport::where('nockee_id', $viewModel->id)->first() ?? new InspectionReport();

	    $inspectionReport->finalized_at = $finalizedAt;
        $inspectionReport->nockee_id = $viewModel->id;
        $inspectionReport->type = $viewModel->type->value;
	    $representativeEmail = $viewModel->getRepresentative?->email;

	    $inspectionReport->user_id = $representativeEmail
		    ? User::where('email', $representativeEmail)->value('id')
		    : User::where('email', 'acapelle@eedl.fr')->value('id');

	    $inspectionReport->address = $viewModel->property()->formatedAddress();

        if (! $inspectionReport->save()) {
            Log::error('Failed to save inspection report data', [
                'id' => $viewModel->id,
                'finalized_at' => $finalizedAt,
            ]);

            throw new \Exception('Failed to save inspection report data');
        }

	    Cache::put("inspection:{$this->inspectionReportData->id}:modelId", $inspectionReport->id);

        return $inspectionReport;

    }
}
