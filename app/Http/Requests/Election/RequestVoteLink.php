<?php

namespace App\Http\Requests\Election;

use App\Rules\Election\NeverVote;
use App\Rules\Election\VerifyEmail;
use App\Services\ElectionService;
use Illuminate\Foundation\Http\FormRequest;

class RequestVoteLink extends FormRequest
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
            'email' => [
                'email', 'ends_with:@widyatama.ac.id', new NeverVote((new ElectionService())->getElectionFromTitle($this->route()->parameter('title')))
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.ends_with' => 'only receive Widyatama University email'
        ];
    }
}
