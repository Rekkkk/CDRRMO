<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccidentReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'report_description' => 'required',
            'report_location' => 'required',
            'contact' => 'required|numeric|digits_between:11,15',
            'email' => 'required|email',
        ];
    }
}