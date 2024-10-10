<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\User;
use App\Models\Voter;
use App\Services\ElectionService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $source = public_path('default.jpg');
        $full_path = "";
        if (file_exists($source)){
            $uploaded = Storage::disk('candidate_photos')->putFileAs('', new File($source), 'default.jpg');
            $full_path = 'public/candidate_photos/' . $uploaded;
            $this->command->info('Image default.jpg copied to storage.');
        }else {
            $this->command->warn('Source file default.jpg not found in public directory.');
        }

        $election = ElectionService::create([
            'title' => 'Testing Vote',
            'active' => true
        ]);
        $election->generations()->create([
            'year' => 2020
        ]);
        $election->generations()->create([
            'year' => 2021
        ]);
        $election->generations()->create([
            'year' => 2022
        ]);

        $electionInActive = ElectionService::create([
            'title' => 'Testing InActive Vote',
            'active' => false
        ]);
        $electionInActive->generations()->create([
            'year' => 2020
        ]);

        $election->candidates()->saveMany([
            new Candidate([
                'name' => fake()->name,
                'vision' => fake()->text(10),
                'mission' => fake()->text(10),
                'number' => 1,
                'photo' => $full_path
            ]),
            new Candidate([
                'name' => fake()->name,
                'vision' => fake()->text(10),
                'mission' => fake()->text(10),
                'number' => 2,
                'photo' => $full_path
            ]),
            new Candidate([
                'name' => fake()->name,
                'vision' => fake()->text(10),
                'mission' => fake()->text(10),
                'number' => 3,
                'photo' => $full_path
            ])
        ]);
        Voter::factory(50)->create()->each(function ($voter) {
            if ($voter) {
                $voter->candidate->update(['counter' => $voter->candidate->counter + 1]);
            }
        });

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);
    }
}
