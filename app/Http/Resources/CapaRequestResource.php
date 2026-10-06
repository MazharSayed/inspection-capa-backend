<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CapaRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'inspection_request_id' => $this->inspection_request_id,
            'project' => $this->project?->name,
            'tower' => $this->tower,
            'division' => $this->division?->name,
            'activity' => $this->activity?->name,
            'sub_activity' => $this->subActivity?->name,
            'defect_type' => $this->defect_type,
            'defect_count' => $this->defect_count,
            'capa_created_at' => $this->capa_created_at?->toIso8601String(),
            'approver' => $this->approver,
            'status' => $this->status,
        ];
    }
}
