<?php

use App\Domain\InspectionReports\Data\InspectionReportData;
use App\Domain\InspectionReports\ViewModels\InspectionReportViewModel;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	$jsonPath = storage_path('pujeau.json');
	$json = file_get_contents($jsonPath);
	$data = json_decode($json, true);
	$reportData = InspectionReportData::from($data);

	$viewModel = new InspectionReportViewModel($reportData);

	return view('inspection.layout', ['data' => $viewModel]);
});

Route::get('inspection-report/{id}/show', [ \App\Http\Controllers\InspectionReport\InspectionReportController::class, 'show'])->name('inspection-report.show');
Route::get('inspection-report/{id}', [ \App\Http\Controllers\InspectionReport\InspectionReportController::class, 'download'])->name('inspection-report.download');
