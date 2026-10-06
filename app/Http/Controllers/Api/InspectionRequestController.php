<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InspectionRequestResource;
use App\Models\InspectionRequest;

class InspectionRequestController extends Controller
{
    public function show(InspectionRequest $inspectionRequest)
    {
        $inspectionRequest->load([
            'project', 'division', 'subDivision', 'activity', 'subActivity',
            'approvals', 'documents',
        ]);

        return new InspectionRequestResource($inspectionRequest);
    }
}
