<?php

namespace Database\Factories;

use App\Models\Election;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voter>
 */
class VoterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $election = Election::where('active', true)->first();
        $generation = $election->generations()->inRandomOrder()->first();
        $candidate = $election->candidates()->inRandomOrder()->first();
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'npm' => fake()->numerify('##########'),
            'generation_id' => $generation->id,
            'election_id' => $election->id,
            'candidate_id' => $candidate->id
        ];
    }
}
