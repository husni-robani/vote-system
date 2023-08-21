<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Generation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $election = Election::create([
            'title' => 'Pemilihan Ketua',
            'active' => true
        ]);
//        $generation = Generation::create([
//            'year' => 2020
//        ]);
        $generation = $election->generations()->create([
            'year' => 2020
        ]);
        $election->candidates()->saveMany([
           new Candidate([
               'name' => 'Husni Robani',
               'vision' => fake()->text(10),
               'mission' => fake()->text(10),
               'number' => 1,
           ]),
            new Candidate([
                'name' => 'Rijal Fauzi Iskandar',
                'vision' => fake()->text(10),
                'mission' => fake()->text(10),
                'number' => 2,
            ]),
            new Candidate([
                'name' => 'Zidan',
                'vision' => fake()->text(10),
                'mission' => fake()->text(10),
                'number' => 3,
            ])
        ]);

        Candidate::first()->voters()->create([
            'name' => 'Alif Nuryana',
            'email' => 'nuryana.alif@widyatama.ac.id',
            'npm' => '13242132',
            'generation_id' => $generation->id,
            'election_id' => $election->id
        ]);

         User::create([
             'name' => 'HIMATIF',
             'email' => 'hima.teknikinformatika@widyatama.ac.id',
             'password' => 'password'
         ]);
    }
}
