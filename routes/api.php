<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CapaRequestController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\InspectionConfigController;
use App\Http\Controllers\Api\InspectionRequestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('filters', [FilterController::class, 'index']);

Route::get('inspection-configs', [InspectionConfigController::class, 'index']);
Route::get('inspection-configs/{inspectionConfig}', [InspectionConfigController::class, 'show']);
Route::put('inspection-configs/{inspectionConfig}', [InspectionConfigController::class, 'update']);

Route::get('capa-requests', [CapaRequestController::class, 'index']);

Route::get('inspection-requests/{inspectionRequest}', [InspectionRequestController::class, 'show']);
Route::get('inspection-requests', [InspectionRequestController::class, 'index']);



