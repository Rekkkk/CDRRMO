<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordEvacueeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'middle_name' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'contact_number' => 'required|numeric|digits:11',
            'age' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'barangay' => 'required',
            'evacuation_center' => 'required',
            'disaster' => 'required',
        ];
    }
}