<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreActivityLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'device_uuid' => ['required', 'string', 'exists:devices,device_uuid'],
            'logs' => ['required', 'array'],
            'logs.*.package_name' => ['required', 'string'],
            'logs.*.app_name' => ['nullable', 'string'],
            'logs.*.start_time' => ['required', 'date'],
            'logs.*.end_time' => ['nullable', 'date'],
            'logs.*.duration_seconds' => ['required', 'integer', 'min:0'],
        ];
    }
}
