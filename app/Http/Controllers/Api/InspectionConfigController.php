<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInspectionConfigRequest;
use App\Http\Resources\SubActivityResource;
use App\Models\SubActivity;
use Illuminate\Http\Request;

class InspectionConfigController extends Controller
{
    private const RELATIONS = ['project', 'activity.subDivision.division'];

    public function index(Request $request)
    {
        $configs = SubActivity::with(self::RELATIONS)
            ->filter($request->only(['project_id', 'division_id', 'sub_division_id', 'activity_id', 'q']))
            ->orderBy('id')
            ->get();

        return SubActivityResource::collection($configs);
    }

    public function show(SubActivity $inspectionConfig)
    {
        return new SubActivityResource($inspectionConfig->load(self::RELATIONS));
    }

    public function update(UpdateInspectionConfigRequest $request, SubActivity $inspectionConfig)
    {
        $inspectionConfig->update($request->validated());

        return new SubActivityResource($inspectionConfig->load(self::RELATIONS));
    }
}
