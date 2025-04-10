<?php

use Illuminate\Support\Facades\Route;

Route::post('/webhook/nockee', \App\Http\Controllers\InspectionReport\WebhookController::class);
