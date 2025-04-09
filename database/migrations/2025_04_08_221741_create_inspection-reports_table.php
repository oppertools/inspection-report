<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspection_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
			$table->string('nockee_id')->index();
			$table->enum('type', \App\Domain\InspectionReports\Enums\InspectionReportType::values());
	        $table->date('finalized_at')->nullable();
	        $table->string('address')->nullable();
	        $table->foreignId('user_id')->nullable();
            $table->string('qrcode_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('zip_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
