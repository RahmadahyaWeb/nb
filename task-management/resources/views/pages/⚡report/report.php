<?php

use App\Models\Project;
use Illuminate\Support\Facades\Response;
use Livewire\Component;

new class extends Component
{
    public $project; // ID project yang dipilih

    public $projects = []; // data project untuk select

    public function mount()
    {
        // Ambil semua project
        $this->projects = Project::orderBy('name')->get();
    }

    public function downloadReport()
    {
        $this->validate([
            'project' => 'required|exists:projects,id',
        ]);

        $project = Project::with(['tasks.category', 'tasks.story_point', 'tasks.estimated_hour', 'tasks.project', 'tasks.user'])->find($this->project);

        // Header CSV, tambah kolom relasi
        $header = array_merge(
            [
                'project',
                'user',
                'order',
                'title',
                'description',
                'priority',
                'category',
                'story_point',
                'estimated_hour',
                'due_date',
                'status',
            ],
        );

        $csvData = implode(',', $header)."\n";

        foreach ($project->tasks as $task) {
            $row = [];

            // Kolom relasi
            $row[] = str_replace(',', ' ', $task->project->name ?? '');
            $row[] = str_replace(',', ' ', $task->user->name ?? '');
            $row[] = str_replace(',', ' ', $task->order ?? '');
            $row[] = str_replace(',', ' ', $task->title ?? '');
            $row[] = str_replace(',', ' ', $task->description ?? '');
            $row[] = str_replace(',', ' ', $task->priority ?? '');
            $row[] = str_replace(',', ' ', $task->category->name ?? '');
            $row[] = str_replace(',', ' ', $task->story_point->value ?? '');
            $row[] = str_replace(',', ' ', $task->estimated_hour->value ?? '');
            $row[] = str_replace(',', ' ', $task->due_date ?? '');
            $row[] = str_replace(',', ' ', $task->status ?? '');

            $csvData .= implode(',', $row)."\n";
        }

        $fileName = "report_{$project->name}.csv";

        return Response::streamDownload(function () use ($csvData) {
            echo $csvData;
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
};
