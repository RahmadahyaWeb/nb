<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\EstimatedHour;
use App\Models\StoryPoint;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================
        // CATEGORY
        // =============================
        $categories = [
            'BUG FIX',
            'DESIGN',
            'DEVELOPMENT',
            'DEVOPS',
            'DOCUMENTATION',
            'ENHANCEMENT',
            'MAINTENANCE',
            'RESEARCH',
            'SECURITY',
            'TESTING',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category,
            ]);
        }

        // =============================
        // STORY POINT (User Friendly)
        // =============================
        $story_points = [
            ['name' => 'Sangat Mudah', 'value' => 1],
            ['name' => 'Mudah', 'value' => 2],
            ['name' => 'Cukup Mudah', 'value' => 3],
            ['name' => 'Menengah', 'value' => 5],
            ['name' => 'Cukup Kompleks', 'value' => 8],
            ['name' => 'Sangat Kompleks', 'value' => 13],
            ['name' => 'Ekstrem', 'value' => 21],
        ];

        foreach ($story_points as $point) {
            StoryPoint::firstOrCreate(
                ['value' => $point['value']],
                $point
            );
        }

        // =============================
        // ESTIMATED HOUR (User Friendly)
        // =============================
        $estimated_hours = [
            ['name' => 'Tugas Minor', 'value' => 2],
            ['name' => 'Tugas Ringan', 'value' => 4],
            ['name' => 'Tugas Harian', 'value' => 8],
            ['name' => 'Tugas Menengah', 'value' => 16],
            ['name' => 'Tugas Besar', 'value' => 24],
            ['name' => 'Fitur Utama', 'value' => 40],
            ['name' => 'Epic / Milestone', 'value' => 80],
        ];

        foreach ($estimated_hours as $hour) {
            EstimatedHour::firstOrCreate(
                ['value' => $hour['value']],
                $hour
            );
        }

        // =============================
        // DEFAULT USER
        // =============================
        User::factory()->create([
            'name' => 'rahmadahya',
            'email' => 'thelastpc24@gmail.com',
        ]);

        $this->call([
            ProjectSeeder::class,
            TaskSeeder::class,
        ]);
    }
}
