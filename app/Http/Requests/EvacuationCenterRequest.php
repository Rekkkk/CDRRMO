<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvacuationCenterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'evacuation_center_name' => 'required',
            'evacuation_center_contact' => 'required|numeric|digits:11',
            'evacuation_center_location' => 'required',
        ];
    }
}