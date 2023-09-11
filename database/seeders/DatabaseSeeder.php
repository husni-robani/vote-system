<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Generation;
use App\Models\User;
use App\Services\ElectionService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $election = ElectionService::create([
            'title' => 'Pemilihan Ketua Himpunan 2022/2023',
            'active' => true
        ]);
        $generation = $election->generations()->create([
            'year' => 2020
        ]);
        $election->candidates()->saveMany([
           new Candidate([
               'name' => 'Husni Robani',
               'vision' => fake()->text(10),
               'mission' => fake()->text(10),
               'number' => 1,
               'photo' => 'public/photo/candidates/default.png'
           ]),
            new Candidate([
                'name' => 'Rijal Fauzi Iskandar',
                'vision' => fake()->text(10),
                'mission' => fake()->text(10),
                'number' => 2,
                'photo' => 'public/photo/candidates/default.png'
            ]),
            new Candidate([
                'name' => 'Zidan',
                'vision' => fake()->text(10),
                'mission' => fake()->text(10),
                'number' => 3,
                'photo' => 'public/photo/candidates/default.png'
            ])
        ]);

        Candidate::first()->voters()->create([
            'name' => 'Alif Nuryana',
            'email' => 'nuryana.alif@widyatama.ac.id',
            'npm' => '13242132',
            'generation_id' => $generation->id,
            'election_id' => $election->id
        ]);

        Candidate::first()->voters()->create([
            'name' => 'test',
            'email' => 'test.@widyatama.ac.id',
            'npm' => '13242132',
            'generation_id' => $generation->id,
            'election_id' => $election->id
        ]);

        Candidate::first()->voters()->create([
            'name' => 'test2',
            'email' => 'test2@widyatama.ac.id',
            'npm' => '13242132',
            'generation_id' => $generation->id,
            'election_id' => $election->id
        ]);

        Candidate::first()->update(['counter' => 3]);

         User::create([
             'name' => 'HIMATIF',
             'email' => 'hima.teknikinformatika@widyatama.ac.id',
             'password' => 'password'
         ]);
    }
}
