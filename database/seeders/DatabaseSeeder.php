<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Election;
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

        $candidate = $election->candidates()->create([
            'name' => 'Husni Robani',
            'vision' => 'test',
            'mission' => 'test',
        ]);

        $election->voters()->create([
            'name' => 'Alif Nuryana',
            'email' => 'nuryana.alif@widyatama.ac.id',
            'npm' => '13242132',
            'gen' => 2020,
            'candidate_id' => $candidate->id
        ]);

         User::create([
             'name' => 'HIMATIF',
             'email' => 'hima.teknikinformatika@widyatama.ac.id',
             'password' => 'password'
         ]);
    }
}
