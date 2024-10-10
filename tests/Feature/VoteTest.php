<?php

namespace Tests\Feature;

use App\Mail\ElectionMail;
use App\Models\VoteLink;
use App\Services\VoteLinkService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class VoteTest extends TestCase
{
    use RefreshDatabase;
    private VoteLink $voteLink;
    protected function setUp(): void
    {
        parent::setUp();
        $this->voteLink = VoteLinkService::createVoteLink($this->activeElection->id, "voter2@example.com");
    }
    public function test_elections_page_rendered_successfully(){
        $response = $this->get(route('election.menu'));

        $response
            ->assertStatus(200);

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Election/Elections')
            ->has('admin.election', fn (Assert $election_props) => $election_props
                ->where('all.0.active', 1)
                ->where('all.1.active', 0)
                ->etc()
            )
        );
    }
    public function test_user_can_access_active_election_request_link_page(){
        $response = $this->get(route('election.requestLink', ['id' => $this->activeElection->id]));

        $response->assertStatus(200);

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Election/Registration')
            ->where('election.selected', $this->activeElection->id)
        );
    }

    public function test_user_cannot_access_inactive_election_request_link_page(){
        $response = $this->get(route('election.requestLink', ['id' => $this->inactiveElection->id]));

        $response->assertStatus(403);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('errors/403')
        );
    }

    public function test_request_vote_link_email_successful(){
        Mail::fake();

        $voterEmail = "voter1@example.com";
        $response = $this->post(route('election.storeEmail', [
            "id" => $this->activeElection->id,
            "email" => $voterEmail
        ]));

        $response->assertStatus(302);
        $this->assertDatabaseHas('vote_links', [
            "email" => $voterEmail
        ]);
        Mail::assertSent(ElectionMail::class, function ($mail) use ($voterEmail){
            return $mail->hasTo($voterEmail);
        });
    }

    public function test_voter_who_has_voted_cannot_request_vote_link(){
        $response = $this->post(route('election.storeEmail', [
            "id" => $this->activeElection->id,
            "email" => $this->voter->email
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function test_cannot_send_request_link_with_not_exist_election(){
        $response = $this->post(route('election.storeEmail', [
            "id" => '123423jkawf',
            "email" => "test@example.com"
        ]));

        $response->assertStatus(404);
    }

    public function test_valid_URL_token_can_access_the_page(){

        $response = $this->get($this->voteLink->link);

        $response->assertStatus(200);

        $response->assertInertia(fn (Assert $page) => $page
            ->component('Election/Vote')
        );
    }

    public function test_invalid_URL_token_cannot_access_vote_page(){
        $response = $this->get(route('election', [
            "id" => $this->activeElection->id,
            "token" => 'token123'
        ]));

        $response->assertStatus(401);
    }

    public function test_invalid_election_id_cannot_access_vote_page(){
        $response = $this->get(route('election', [
            "id" => "wrongId123",
            "token" => $this->voteLink->token
        ]));

        $response->assertStatus(404);
    }

    public function test_store_personal_information_step_successfull(){
        $data = [
            "name" => "Husni Robani",
            "npm" => "123456789",
            "generation_id" => $this->activeElection->generations()->first()->id
        ];
        $response = $this->post(route('election.first-step', [
            'id' => $this->voteLink->election->id,
            'token' => $this->voteLink->token
        ]), $data);

        $response->assertStatus(302);
    }
    public function test_cannot_store_vote_candidate_with_invalid_token(){
        $data = [
            "name" => "Husni Robani",
            "npm" => "123456789",
            "generation_id" => $this->activeElection->generations()->first()->id,
            "candidate_id" => $this->activeElection->candidates()->first()->id
        ];
        $response = $this->post(route('election.store', [
          'id' => $this->voteLink->election->id,
          'token' => 'invalidToken123'
        ]), $data);

        $response->assertStatus(403);
    }
    public function test_store_vote_candidate_step_successful(){
        $chosen_candidate = $this->activeElection->candidates()->first();
        $voter_candidate_count = $chosen_candidate->counter;
        $data = [
            "name" => "Husni Robani",
            "npm" => "123456789",
            "generation_id" => $this->activeElection->generations()->first()->id,
            "candidate_id" => $chosen_candidate->id
        ];
        $response = $this->post('election/' . $this->voteLink->election->id . '/' . $this->voteLink->token, $data);
        $response->assertStatus(201);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Election/Finish')
            ->has('link')
            ->where('link', $this->activeElection->resultLink->link)
        );

        $this->assertEquals($voter_candidate_count + 1, $this->activeElection->candidates()->first()->counter);
        $this->assertDatabaseMissing('vote_links', ['id' => $this->voteLink->id]);
    }


}
