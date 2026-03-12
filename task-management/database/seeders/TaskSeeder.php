<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\EstimatedHour;
use App\Models\StoryPoint;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // ambil user pertama

        // Ambil master data berdasarkan value/nama
        $categories = Category::all()->keyBy('name'); // ['BUG FIX' => Category, ...]
        $story_points = StoryPoint::all()->keyBy('value'); // [1 => StoryPoint, 2 => ..., 21 => ...]
        $estimated_hours = EstimatedHour::all()->keyBy('value'); // [2 => EH, 4 => ..., 80 => ...]

        $tasks = [
            [
                'title' => 'Fix login bug',
                'description' => 'Resolve the issue preventing users from logging in with valid credentials.',
                'category_name' => 'BUG FIX',
                'story_point_value' => 2,
                'estimated_hour_value' => 2,
                'due_date' => Carbon::today()->addDays(1),
            ],
            [
                'title' => 'Redesign landing page',
                'description' => 'Update the landing page layout to improve user engagement and conversion.',
                'category_name' => 'DESIGN',
                'story_point_value' => 5,
                'estimated_hour_value' => 16,
                'due_date' => Carbon::today()->addDays(5),
            ],
            [
                'title' => 'Implement payment gateway',
                'description' => 'Integrate Stripe API for handling payments securely.',
                'category_name' => 'DEVELOPMENT',
                'story_point_value' => 8,
                'estimated_hour_value' => 24,
                'due_date' => Carbon::today()->addDays(7),
            ],
            [
                'title' => 'Setup CI/CD pipeline',
                'description' => 'Automate build and deployment process using GitHub Actions.',
                'category_name' => 'DEVOPS',
                'story_point_value' => 8,
                'estimated_hour_value' => 24,
                'due_date' => Carbon::today()->addDays(10),
            ],
            [
                'title' => 'Write API documentation',
                'description' => 'Document all endpoints with examples for frontend developers.',
                'category_name' => 'DOCUMENTATION',
                'story_point_value' => 3,
                'estimated_hour_value' => 8,
                'due_date' => Carbon::today()->addDays(3),
            ],
            [
                'title' => 'Optimize database queries',
                'description' => 'Improve performance by adding indexes and optimizing SQL queries.',
                'category_name' => 'ENHANCEMENT',
                'story_point_value' => 5,
                'estimated_hour_value' => 16,
                'due_date' => Carbon::today()->addDays(4),
            ],
            [
                'title' => 'Server maintenance',
                'description' => 'Perform routine maintenance on production servers to ensure uptime.',
                'category_name' => 'MAINTENANCE',
                'story_point_value' => 3,
                'estimated_hour_value' => 8,
                'due_date' => Carbon::today()->addDays(2),
            ],
            [
                'title' => 'Research new authentication method',
                'description' => 'Investigate the feasibility of implementing passwordless login.',
                'category_name' => 'RESEARCH',
                'story_point_value' => 13,
                'estimated_hour_value' => 40,
                'due_date' => Carbon::today()->addDays(14),
            ],
            [
                'title' => 'Security audit',
                'description' => 'Perform security audit on the application to identify vulnerabilities.',
                'category_name' => 'SECURITY',
                'story_point_value' => 8,
                'estimated_hour_value' => 24,
                'due_date' => Carbon::today()->addDays(6),
            ],
            [
                'title' => 'Automated testing setup',
                'description' => 'Setup unit and integration tests for backend API.',
                'category_name' => 'TESTING',
                'story_point_value' => 5,
                'estimated_hour_value' => 16,
                'due_date' => Carbon::today()->addDays(5),
            ],
            // 11–20: bisa ditambahkan mirip di atas, variasi nama & complexity
        ];

        foreach ($tasks as $task) {
            Task::create([
                'title' => $task['title'],
                'description' => $task['description'],
                'category_id' => $categories[$task['category_name']]->id,
                'story_point_id' => $story_points[$task['story_point_value']]->id,
                'estimated_hour_id' => $estimated_hours[$task['estimated_hour_value']]->id,
                'due_date' => $task['due_date'],
                'user_id' => $user->id,
                'project_id' => 1
            ]);
        }
    }
}
