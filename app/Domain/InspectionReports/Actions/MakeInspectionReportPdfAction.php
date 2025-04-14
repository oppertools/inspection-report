<?php

namespace App\Domain\InspectionReports\Actions;

use App\Domain\InspectionReports\Data\InspectionReportData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

readonly class MakeInspectionReportPdfAction
{
	public function __construct(
		private string $inspectionId,
	) {
	}

	public function handle(): bool
	{
		Log::info('Api Started');
		$response = Http::withHeaders([
			'X-api-key' => '0JJtMVIc0aly3JJMxF5ccivn4Y51jiZsFIy2DfgrA36JfTWdgY',
			'Accept' => 'application/json',
		])->get("https://api.nockee.eu/v2/inspection_reports/{$this->inspectionId}", [
			'expand' => 'keys,keys__pictures,meters,meters__pictures,pictures,rooms,rooms__elements,rooms__elements__pictures,rooms__pictures,signatories'
		]);

		if (! $response->successful()) {
			return false;
		}

		$data = $response->json();

		try {
			$inspectionReportData = InspectionReportData::from($data);
			(new BuildInspectionReportAction($inspectionReportData))->handle();
			return true;
		} catch (\Throwable $e) {
			Log::error('Error while requesting API:', [
				'error' => $e->getMessage(),
				'trace' => $e->getTraceAsString(),
			]);
			return false;
		}
	}
}
