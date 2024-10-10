<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Voter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class VoterTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::create([
            'email' => 'admin@example.com',
            "name" => "Admin",
            "password" => "password",
            'email_verified_at' => now()
        ]);
    }

    public function test_voters_page_rendered_successful(){
        $response = $this->actingAs($this->admin)->get(route('admin.vote-system.voters', [
            'id' => $this->activeElection->id
        ]));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->has('voters.data', 1, fn (Assert $voters) => $voters
                    ->where('email', $this->activeElection->voters()->first()->email)
                    ->where('id', $this->activeElection->voters()->first()->id)
                    ->etc()
                )
            );
    }

    public function test_voters_page_pagination_works(){
        Voter::factory(50)->create()->each(function ($voter) {
            if ($voter) {
                $voter->candidate->update(['counter' => $voter->candidate->counter + 1]);
            }
        });

        $response = $this->actingAs($this->admin)->get(route('admin.vote-system.voters', [
            'id' => $this->activeElection->id
        ]));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->has('voters.data', 10)
            );
    }

    public function test_voter_destroy_successful(){
        $deletedVoter = $this->activeElection->voters()->first();
        $response = $this->actingAs($this->admin)->delete(route('admin.vote-system.voter.destroy', [
            'id' => $this->activeElection->id,
            'voterId' => $deletedVoter->id
        ]));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('voters', $deletedVoter->toArray())
            ->assertDatabaseCount('voters', 0);
    }

    public function test_voter_destroy_with_wrong_voter_id_failed(){
        $response = $this->actingAs($this->admin)->delete(route('admin.vote-system.voter.destroy', [
            'id' => $this->activeElection->id,
            'voterId' => 'wrongVoterId'
        ]));

        $response->assertStatus(500);
    }
}
