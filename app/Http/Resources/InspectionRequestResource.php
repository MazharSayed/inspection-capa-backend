<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InspectionRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project' => $this->project?->name,
            'status' => $this->status,
            'requested_at' => $this->requested_at?->toIso8601String(),
            'details' => [
                'floor' => $this->floor,
                'unit' => $this->unit,
                'division' => $this->division?->name,
                'sub_division' => $this->subDivision?->name,
                'activity' => $this->activity?->name,
                'sub_activity' => $this->subActivity?->name,
                'technician' => $this->technician,
            ],
            'documents' => $this->documents->map(fn ($document) => [
                'id' => $document->id,
                'name' => $document->name,
                'url' => $document->url,
            ]),
            'approvals' => $this->approvals->map(fn ($approval) => [
                'id' => $approval->id,
                'role' => $approval->role,
                'approver_name' => $approval->approver_name,
                'avatar_url' => $approval->avatar_url,
                'status' => $approval->status,
                'comment' => $approval->comment,
                'acted_at' => $approval->acted_at?->toIso8601String(),
            ]),
        ];
    }
}
