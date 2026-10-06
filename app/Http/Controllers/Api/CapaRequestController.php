<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CapaRequestResource;
use App\Models\CapaRequest;
use Illuminate\Http\Request;

class CapaRequestController extends Controller
{
    public function index(Request $request)
    {
        $capaRequests = CapaRequest::with(['project', 'division', 'activity', 'subActivity'])
            ->filter($request->only([
                'project_id', 'division_id', 'sub_division_id', 'activity_id',
                'sub_activity_id', 'created_at', 'status', 'q',
            ]))
            ->orderByDesc('id')
            ->get();

        return CapaRequestResource::collection($capaRequests);
    }
}
