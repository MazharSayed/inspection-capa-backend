<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InspectionRequestListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project' => $this->project?->name,
            'tower' => $this->tower,
            'floor' => $this->floor,
            'unit' => $this->unit,
            'division' => $this->division?->name,
            'sub_division' => $this->subDivision?->name,
            'activity' => $this->activity?->name,
            'sub_activity' => $this->subActivity?->name,
            'technician' => $this->technician,
            'status' => $this->status,
            'requested_at' => $this->requested_at?->toIso8601String(),
            'approval_statuses' => $this->approvals->pluck('status'),
        ];
    }
}
