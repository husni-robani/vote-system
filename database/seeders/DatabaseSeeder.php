<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Candidate;
use App\Models\User;
use App\Services\ElectionService;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $election = ElectionService::create([
            'title' => 'Testing Vote',
            'active' => false
        ]);
        $election->generations()->create([
            'year' => 2021
        ]);

        $election = ElectionService::create([
            'title' => 'Testing Vote Active',
            'active' => true
        ]);
        $generation = $election->generations()->create([
            'year' => 2020
        ]);

        $source = public_path('default.jpg');
        $path = "";
        if (file_exists($source)){
            $path = Storage::putFile('public/photo/candidates', new File($source));
            $this->command->info('Image default.jpg copied to storage.');
        }else {
            $this->command->warn('Source file default.jpg not found in public directory.');
        }


        $election->candidates()->saveMany([
           new Candidate([
               'name' => fake()->name,
               'vision' => fake()->text(10),
               'mission' => fake()->text(10),
               'number' => 1,
               'photo' => $path
           ]),
            new Candidate([
                'name' => fake()->name,
                'vision' => fake()->text(10),
                'mission' => fake()->text(10),
                'number' => 2,
                'photo' => $path
            ]),
            new Candidate([
                'name' => fake()->name,
                'vision' => fake()->text(10),
                'mission' => fake()->text(10),
                'number' => 3,
                'photo' => $path
            ])
        ]);

        Candidate::first()->voters()->create([
            'name' => fake()->name,
            'email' => fake()->email,
            'npm' => '13242132',
            'generation_id' => $generation->id,
            'election_id' => $election->id
        ]);

        Candidate::first()->voters()->create([
            'name' => fake()->name,
            'email' => fake()->email,
            'npm' => '13242132',
            'generation_id' => $generation->id,
            'election_id' => $election->id
        ]);

        Candidate::first()->voters()->create([
            'name' => fake()->name,
            'email' => fake()->email,
            'npm' => '13242132',
            'generation_id' => $generation->id,
            'election_id' => $election->id
        ]);

        Candidate::first()->update(['counter' => 3]);

         User::create([
             'name' => 'Admin',
             'email' => 'admin@example.com',
             'password' => 'password'
         ]);
    }
}
