<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::create([
            'user_id' => '1',
            'name' => 'Project Naive Bayes',
            'description' => 'Description of naive bayes project',
            'start_date' => '2026-01-01',
            'end_date' => '2026-02-01'
        ]);
    }
}
