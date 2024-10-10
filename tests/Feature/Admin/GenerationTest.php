<?php

namespace Tests\Feature\Admin;

use App\Models\Generation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerationTest extends TestCase
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

    public function test_store_new_generation_successful(){
        $response = $this->actingAs($this->admin)->post(route('admin.vote-system.update.gen', [
            'id' => $this->activeElection->id
        ]), [
            'year' => 2021
        ]);

        $response->assertStatus(302)
            ->assertRedirectToRoute('admin.vote-System.edit', [
                'id' => $this->activeElection->id
            ]);
        $this->assertDatabaseCount('generations',2)
            ->assertDatabaseHas('generations', [
                'year' => 2021
            ]);
    }

    public function test_cannot_store_new_generation_without_year_field(){
        $response = $this->actingAs($this->admin)->post(route('admin.vote-system.update.gen', [
            'id' => $this->activeElection->id
        ]));

        $response->assertStatus(302)
            ->assertSessionHasErrors('year');
    }

    public function test_abort_store_new_generation_with_wrong_election_id(){
        $response = $this->actingAs($this->admin)->post(route('admin.vote-system.update.gen', [
            'id' => "wrongId"
        ]), ['year' => 2021]);

        $response->assertStatus(401)
            ->assertUnauthorized();
    }

    public function test_destroy_generation_successful(){
        $deleted_gen = $this->activeElection->generations()->first();
        $response = $this->actingAs($this->admin)->delete(route('admin.vote-system.delete.gen', [
            'id' => $this->activeElection->id,
            'genId' => $deleted_gen->id
        ]));

        $response->assertStatus(302)
            ->assertRedirectToRoute('admin.vote-System.edit', ['id' => $this->activeElection->id]);

        $this->assertDatabaseMissing('generations', $deleted_gen->toArray())
            ->assertDatabaseCount('generations', 0);

        $this->assertEquals(0, $this->activeElection->generations()->count());
    }

    public function test_abort_destroy_generation_with_wrong_gen_id(){
        $response = $this->actingAs($this->admin)->delete(route('admin.vote-system.delete.gen', [
            'id' => $this->activeElection->id,
            'genId' => "wrong generation id"
        ]));

        $response->assertStatus(500);
    }
}
