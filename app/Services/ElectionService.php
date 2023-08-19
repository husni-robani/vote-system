<?php

namespace App\Services;

use App\Models\Election;

class ElectionService{
    public function getElectionFromTitle(string $title) : Election
    {
        return Election::where('title', $title)->first();
    }
}