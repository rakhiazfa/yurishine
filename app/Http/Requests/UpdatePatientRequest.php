<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'age' => ['required', 'numeric', 'min:5'],
            'gender' => ['required', Rule::in(['Pria', 'Wanita'])],
            'skin_type' => ['required'],
            'address' => ['required'],
            'phone' => ['required', 'numeric'],
            'is_smoked' => ['required', 'boolean'],
            'using_kb' => ['required'],
            'using_skincare' => ['required', 'boolean'],
            'already_use_mixed_cream' => ['required', 'boolean'],
        ];
    }
}
