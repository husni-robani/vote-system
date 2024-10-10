<?php

namespace Tests\Feature;

use App\Models\ResultLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class ResultLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_result_link_rendered_successful(){
        $response = $this->get(route('election.result', ['id' => $this->activeElection->id]));

        $this->assertDatabaseHas(ResultLink::class, [
            'id' => $this->activeElection->resultLink->id,
            'link' => $this->activeElection->resultLink->link
        ]);
        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Election/Result')
            ->has('election', fn (Assert $election_props) => $election_props
                ->where('id', $this->activeElection->id)
                ->has('candidates', 1, fn (Assert $candidate_props) => $candidate_props
                    ->where('id', $this->activeElection->candidates()->first()->id)
                    ->etc()
                )
                ->has('voters', 1)
                ->etc()
            )
        );
    }
}
