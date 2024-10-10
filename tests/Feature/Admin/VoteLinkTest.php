<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Services\VoteLinkService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class VoteLinkTest extends TestCase
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
    public function test_vote_link_page_rendered_successful(){
        VoteLinkService::createVoteLink($this->activeElection->id, 'test@example.com');
        $response = $this->actingAs($this->admin)->get(route('admin.vote-system.voteLinks', [
            'id' => $this->activeElection
        ]));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->has('links', 1)
            );
    }

    public function test_vote_link_page_cannot_rendered_with_wrong_election_id(){
        $response = $this->actingAs($this->admin)->get(route('admin.vote-system.voteLinks', [
            'id' => 'wrongId'
        ]));
        $response->assertStatus(401);
    }
}
