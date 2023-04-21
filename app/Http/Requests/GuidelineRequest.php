<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuidelineRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guideline_description' => 'required',
        ];
    }
}