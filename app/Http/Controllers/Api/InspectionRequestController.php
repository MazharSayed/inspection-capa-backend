<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InspectionRequestResource;
use App\Models\InspectionRequest;
use App\Http\Resources\InspectionRequestListResource;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $inspectionRequests = InspectionRequest::with([
                'project', 'division', 'subDivision', 'activity', 'subActivity', 'approvals',
            ])
            ->filter($request->only([
                'project_id', 'division_id', 'sub_division_id', 'activity_id', 'status', 'q',
            ]))
            ->orderByDesc('requested_at')
            ->orderByDesc('id')
            ->get();

        return InspectionRequestListResource::collection($inspectionRequests);
    }
}
