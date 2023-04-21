<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'barangay_name' => 'required',
            'barangay_location' => 'required',
            'barangay_contact' => 'required|numeric|digits:11',
            'barangay_email' => 'required|email:rfc,dns',
        ];
    }
}