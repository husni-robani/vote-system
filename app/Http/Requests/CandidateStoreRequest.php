<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'numeric', 'between:1,20'],
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:50'],
            'vision' => 'required',
            'mission' => 'required',
            'photo' => 'nullable|image'
        ];
    }
}
