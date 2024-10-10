<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class CandidateTest extends TestCase
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

    public function test_candidates_page_rendered_successful(){
        $response = $this->actingAs($this->admin)->get(route('admin.vote-system.candidates', ['id' => $this->activeElection->id]));

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/Election/Candidates')
            ->has('candidates', $this->activeElection->candidates()->count())
            ->has('totalVoter', $this->activeElection->voters->count())
        );
    }

    public function test_store_candidate_with_photo_successful(){
        Storage::fake('candidate_photos');
        $file = UploadedFile::fake()->image('test_photo.jpg');
        $data = [
            "number" => 2,
            "name" => "Candidate",
            "vision" => "Vision Test",
            "mission" => "Mission Test",
            "photo" => $file
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.vote-system.candidate.store', [
            'id' => $this->activeElection->id
        ]), $data);

        $response
            ->assertStatus(302)
            ->assertRedirectToRoute('admin.vote-system.candidates', ['id' => $this->activeElection->id])
            ->assertSessionHas('success', 'New Candidate Success to Added');

        $this->assertDatabaseCount('candidates', 2)
            ->assertDatabaseHas('candidates', [
                'photo' => 'public/candidate_photos/' . $file->hashName()
            ]);

        Storage::disk('candidate_photos')->assertExists($file->hashName());
    }

    public function test_store_candidate_without_photo_successful(){
        $source = public_path('default.jpg');
        Storage::fake('candidate_photos');
        Storage::disk('candidate_photos')->putFileAs('', new File($source), 'default.jpg');
        $data = [
            "number" => 2,
            "name" => "Candidate",
            "vision" => "Vision Test",
            "mission" => "Mission Test",
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.vote-system.candidate.store', [
            'id' => $this->activeElection->id
        ]), $data);

        $response
            ->assertStatus(302)
            ->assertRedirectToRoute('admin.vote-system.candidates', ['id' => $this->activeElection->id])
            ->assertSessionHas('success', 'New Candidate Success to Added');

        $this->assertDatabaseCount('candidates', 2)
            ->assertDatabaseHas('candidates', [
                'photo' => 'public/candidate_photos/default.jpg'
            ]);

        Storage::disk('candidate_photos')->assertExists('default.jpg');
    }

    public function test_edit_candidate_page_rendered_successful(){
        $selected_candidate = $this->activeElection->candidates()->first();
        $response = $this->actingAs($this->admin)->get(route('admin.vote-system.candidate.edit', [
            'id' => $this->activeElection->id,
            'candidateId' => $selected_candidate->id
        ]));

        $response->assertStatus(200);
        $response->assertInertia(fn (Assert $page) => $page
            ->where('candidate', $selected_candidate->getAttributes())
            ->where('voters', $selected_candidate->voters()->with('generation')->get())
            ->has('voter_by_gen', $selected_candidate->election->generations->count())
        );
    }

    public function test_update_candidate_successful(){
        $data = [
            "number" => 5,
            "name" => "Test Candidate Update",
            "vision" => "Test Visi Update",
            "mission" => "Test Misi update"
        ];
        $election = $this->activeElection;
        $updatedCandidate = $election->candidates()->first();

        $response = $this->actingAs($this->admin)->patch(route('admin.vote-system.candidate.update', [
            'id' => $election->id,
            'candidateId' => $updatedCandidate->id
        ]), $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('candidates', $data);
    }

    public function test_cannot_update_candidate_without_data(){
        $election = $this->activeElection;
        $updatedCandidate = $election->candidates()->first();

        $response = $this->actingAs($this->admin)->patch(route('admin.vote-system.candidate.update', [
            'id' => $election->id,
            'candidateId' => $updatedCandidate->id
        ]), []);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['number', 'name', 'vision', 'mission']);
    }

    public function test_destroy_candidate_successful(){
        $candidate = $this->activeElection->candidates()->first();

        $response = $this->actingAs($this->admin)->delete(route('admin.vote-system.candidate.delete', [
            'id' => $this->activeElection->id,
            'candidateId' => $candidate->id
        ]));

        $response->assertStatus(302)
            ->assertRedirectToRoute('admin.vote-system.candidates', ['id' => $this->activeElection->id])
            ->assertSessionHas('success', 'Candidate Success to Delete');

        $this->assertDatabaseMissing('candidates', $candidate->toArray())
            ->assertDatabaseCount('candidates', 0);
    }
}
