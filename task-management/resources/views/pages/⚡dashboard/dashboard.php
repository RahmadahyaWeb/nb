<?php

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $projects;

    public function mount()
    {
        $this->projects = $this->dashboard_data();
    }

    public function dashboard_data()
    {
        $projects = Project::withCount([
            'tasks as total_task',
            'tasks as total_done' => function ($q) {
                $q->where('status', 'done');
            },
            'tasks as total_todo' => function ($q) {
                $q->where('status', 'todo');
            },
            'tasks as total_in_progress' => function ($q) {
                $q->where('status', 'in_progress');
            },
            'tasks as total_review' => function ($q) {
                $q->where('status', 'review');
            },
        ])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($project) {

                $project->percentage = $project->total_task > 0
                    ? round(($project->total_done / $project->total_task) * 100)
                    : 0;

                return $project;
            });

        return $projects;
    }
};
