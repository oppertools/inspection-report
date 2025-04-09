<?php

namespace App\Domain\InspectionReports\Models;

use App\Domain\InspectionReports\Enums\InspectionReportType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InspectionReport extends Model
{
	use HasUuids;
    protected $fillable = [
        'id',
        'qrcode_path',
        'pdf_path',
        'zip_path',
        'finalized_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'finalized_at' => 'date',
	    'type' => InspectionReportType::class,
    ];
}
