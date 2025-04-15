<?php

namespace App\Http\Controllers\InspectionReport;

use App\Domain\InspectionReports\Models\InspectionReport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class InspectionReportController extends Controller
{
	public function download(string $id)
	{
		$inspectionReport = InspectionReport::findOrFail($id);

		if (! Storage::disk('s3')->exists($inspectionReport->pdf_path)) {
			abort(404, 'Fichier introuvable');
		}

		$file = Storage::disk('s3')->get($inspectionReport->pdf_path);

		$filename = "etat-des-lieux-{$inspectionReport->address}-{$inspectionReport->finalized_at->format('Y-m-d')}.pdf";

		return response($file)
			->header('Content-Type', 'application/pdf')
			->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
			->header('Content-Length', strlen($file));
	}

	public function show(string $id)
	{
		$inspectionReport = InspectionReport::where('nockee_id', $id)->first();

		if(!$inspectionReport) {
			abort(404, 'Inspection report not found');
		}

		$filePath = Storage::disk('s3')->url(
			$inspectionReport->pdf_path
		);
		$zipPath = Storage::disk('s3')->url(
			$inspectionReport->zip_path
		);

		return view('inspection.show', [
			'inspectionReport' => $inspectionReport,
			'zipPath' => $zipPath,
		]);
	}
}
