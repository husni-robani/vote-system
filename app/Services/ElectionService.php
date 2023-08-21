<?php

namespace App\Services;

use App\Models\Election;
use Illuminate\Http\Request;


class ElectionService{
    private Election $election;

    /**
     * @param Election $election
     */
    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    public static function getElectionFromTitle(string $title) : Election
    {
        return Election::where('title', $title)->first();
    }

    public function createVoter(Request $request){
        $this->election->voters()->create($request->all());
        return $this;
    }

}