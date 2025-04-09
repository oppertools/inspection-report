<?php

namespace App\Http\Controllers\InspectionReport;

use App\Domain\InspectionReports\Actions\BuildInspectionReportAction;
use App\Domain\InspectionReports\Data\InspectionReportData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * @throws \Exception
     */
	public function __invoke()
	{

		Log::info('Webhook validated', [
			'request' => request()->all(),
		]);

		return response()->json(['status' => 'ok'], 200);
	}


}
