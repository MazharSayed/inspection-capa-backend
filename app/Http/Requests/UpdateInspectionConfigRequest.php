<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInspectionConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'level_engineer' => ['sometimes', 'boolean'],
            'level_qcs' => ['sometimes', 'boolean'],
            'level_qaqc' => ['sometimes', 'boolean'],
            'random_inspection_count' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
