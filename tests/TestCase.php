<?php

namespace Tests;

use App\Models\Election;
use App\Models\Voter;
use App\Services\ElectionService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected Election $activeElection;
    protected Election $inactiveElection;
    protected Voter $voter;
    protected function setUp(): void
    {
        parent::setUp();
        $this->activeElection = ElectionService::create([
            "title" => "Active Election",
            "active" => true
        ]);
        $this->activeElection->generations()->create([
            "year" => 2020,
        ]);

        $this->activeElection->candidates()->create([
            "name" => "Candidate 1",
            "number" => 1,
            "mission" => "Mission Test",
            "vision" => "Vision Test"
        ]);

        $this->voter = $this->activeElection->voters()->create([
            "name" => "Voter 1",
            "email" => "voter@example.com",
            "npm" => "00012312",
            "candidate_id" => $this->activeElection->candidates->first()->id,
            "generation_id" => $this->activeElection->generations()->first()->id
        ]);

        $this->inactiveElection = ElectionService::create([
            "title" => "Inactive Election",
            "active" => false
        ]);
    }
}
