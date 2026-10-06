<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'project' => $this->project?->name,
            'division' => $this->activity?->subDivision?->division?->name,
            'sub_division' => $this->activity?->subDivision?->name,
            'activity' => $this->activity?->name,
            'level_engineer' => $this->level_engineer,
            'level_qcs' => $this->level_qcs,
            'level_qaqc' => $this->level_qaqc,
            'random_inspection_count' => $this->random_inspection_count,
        ];
    }
}
