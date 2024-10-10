<?php

namespace Tests\Feature\Admin;

use App\Models\Election;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ElectionTest extends TestCase
{
    use RefreshDatabase;
    private User $admin;
    protected function setUp(): void
    {
        parent::setUp();

        \Session::start();

        $this->admin = User::create([
            'email' => 'admin@example.com',
            "name" => "Admin",
            "password" => "password",
            'email_verified_at' => now()
        ]);
    }

    public function test_unauthenticated_user_cannot_access_election_dashboard(){
        $url = 'admin/vote-system/' . $this->activeElection->id;
        $response = $this->get($url);

        $response->assertStatus(302)
            ->assertRedirect('/login');
    }
    public function test_authenticated_user_can_access_election_dashboard(){
        $election = $this->activeElection;
        $url = 'admin/vote-system/' . $election->id;

        $response = $this->actingAs($this->admin)->get($url);

        $response->assertStatus(200);

        $response->assertInertia(fn (Assert $page) => $page
            -> component('Admin/Election/Dashboard')
            ->has('election', fn (Assert $prop) => $prop
                ->where('id', $election->id)
                ->has('candidates', $election->candidates()->count())
                ->has('voters', $election->voters()->count())
                ->etc()
            )
        );
    }

    public function test_create_election_page_rendered_successful(){
        $url = 'admin/vote-system/create/' . $this->activeElection->id;
        $response = $this->actingAs($this->admin)->get($url);

        $response->assertStatus(200);
    }

    public function test_store_new_election_successful(){
        $url = 'admin/vote-system/create/' . $this->activeElection->id;

        $data = [
            'title' => 'test election',
            'active' => false
        ];
        $response = $this->actingAs($this->admin)->post($url, $data);

        $new_election = Election::where('title', $data['title'])->first();
        $response
            ->assertStatus(302)
            ->assertRedirect('admin/vote-system/' . $new_election->id);

        $this->assertDatabaseCount('elections', 3)
            ->assertDatabaseCount('result_links', 3);
    }

    public function test_switch_election_successful(){
        $selected_election = Election::inRandomOrder()->first();
        $url = 'admin/vote-system/switch/' . $selected_election->id;

        $response = $this->actingAs($this->admin)->get($url);

        $response->assertStatus(302)->assertRedirect('admin/vote-system/' . $selected_election->id);
    }

    public function test_edit_election_page_rendered_successful(){
        $url = 'admin/vote-System/' . $this->inactiveElection->id . '/edit';
        $response = $this->actingAs($this->admin)->get($url);

        $response->assertStatus(200);

        $response->assertInertia(fn (Assert $page) => $page
            ->has('admin.election.selected', fn (Assert $props) => $props
                ->where('id', $this->inactiveElection->id)
                ->where('title', $this->inactiveElection->title)
                ->where('active', $this->inactiveElection->active ? 1 : 0)
                ->etc()
            )
        );
    }

    public function test_update_election_successful(){
        $url = 'admin/vote-system/' . $this->inactiveElection->id . '/update';
        $new_update = [
            "title" => "Title Updated",
            "active" => true
        ];

        $response = $this->actingAs($this->admin)->patch($url, $new_update);
        $response->assertStatus(302)
            ->assertRedirect('/');

        $this->assertDatabaseHas('elections', $new_update);
    }

    public function test_destroy_election_successful(){
        $url = 'admin/vote-system/' . $this->inactiveElection->id . '/delete';
        $response = $this->actingAs($this->admin)->delete($url);

        $response->assertStatus(302)
            ->assertRedirectToRoute('admin.vote-system.random')
            ->assertSessionHas('success', 'Delete Election Success');

        $this->assertDatabaseMissing('elections', $this->inactiveElection->toArray());
    }

    public function test_cannot_destroy_last_election(){
        // Delete 1 election, so only 1 election left on the table
        Election::find($this->inactiveElection->id)->delete();
        $url = 'admin/vote-system/' . $this->activeElection->id . '/delete';
        $response = $this->actingAs($this->admin)->delete($url);

        $response
            ->assertStatus(302)
            ->assertSessionHas('failed', 'This is the only election existence. You cannot delete it');

        $this->assertDatabaseCount('elections', 1);
    }
}
