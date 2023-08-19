<?php

namespace App\Rules\Election;

use App\Models\Election;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NeverVote implements ValidationRule
{
    private Election $election;
    public function __construct( Election $election)
    {
        $this->election = $election;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->election->voters->contains('email', $value)){
            $fail("you've already voted");
        }

    }
}
