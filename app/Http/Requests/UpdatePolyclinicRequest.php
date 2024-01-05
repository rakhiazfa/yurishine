<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePolyclinicRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $polyclinic = $this->route('polyclinic');

        return [
            'name' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $polyclinic->user->id],
            'password' => ['nullable', 'min:8'],
        ];
    }
}
