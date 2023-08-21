<?php
namespace App\Services;

use App\Models\Candidate;

class CandidateService{
    private Candidate $candidate;

    /**
     * @param Candidate $candidate
     */
    public function __construct(Candidate $candidate)
    {
        $this->candidate = $candidate;
    }

    public function addCounter(){
        $this->candidate->counter = $this->candidate->getAttribute('counter') + 1;
        $this->candidate->save();
    }

}