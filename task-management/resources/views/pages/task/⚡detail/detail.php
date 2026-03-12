<?php

use App\Models\Category;
use App\Models\EstimatedHour;
use App\Models\Project;
use App\Models\StoryPoint;
use App\Models\Task;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $title;

    public $description;

    public $category_id;

    public $story_point_id;

    public $estimated_hour_id;

    public $due_date;

    public $status;

    public $notes;

    public $order;

    public Project $project;

    public $is_edit = false;

    public $task_id, $task_to_delete_id;

    public $visible_columns = [
        'order' => true,
        'title' => true,
        'description' => false,
        'priority' => true,
        'category' => true,
        'story_point' => false,
        'estimated_hour' => false,
        'due_date' => true,
        'status' => true,
    ];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    // =============================
    // COMPUTED: TASK LIST
    // =============================
    #[Computed()]
    public function tasks()
    {
        $tasks = Task::with([
            'user',
            'category',
            'story_point',
            'estimated_hour',
        ])
            ->where('project_id', $this->project->id)
            ->where('user_id', Auth::id())
            ->orderBy('order', 'asc')
            ->paginate(10);

        return $tasks;
    }

    // =============================
    // COMPUTED: CATEGORY LIST
    // =============================
    #[Computed]
    public function categories()
    {
        return Category::orderBy('name')->get();
    }

    // =============================
    // COMPUTED: STORY POINT LIST
    // =============================
    #[Computed]
    public function story_points()
    {
        return StoryPoint::orderBy('value')->get();
    }

    // =============================
    // COMPUTED: ESTIMATED HOUR LIST
    // =============================
    #[Computed()]
    public function estimated_hours()
    {
        return EstimatedHour::orderBy('value')->get();
    }

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'story_point_id' => 'required|exists:story_points,id',
        'estimated_hour_id' => 'required|exists:estimated_hours,id',
        'due_date' => 'required|date',
        'status' => 'required|string',
        'notes' => 'nullable|string',
    ];

    protected $messages = [
        'title.required' => 'Please enter a title for the task.',
        'title.string' => 'The title must be a valid text.',
        'title.max' => 'The title cannot exceed 255 characters.',

        'description.required' => 'Please provide a description for the task.',
        'description.string' => 'The description must be valid text.',

        'category_id.required' => 'Please select a category.',
        'category_id.exists' => 'The selected category is invalid.',

        'story_point_id.required' => 'Please select a complexity level.',
        'story_point_id.exists' => 'The selected complexity level is invalid.',

        'estimated_hour_id.required' => 'Please select an estimated duration.',
        'estimated_hour_id.exists' => 'The selected duration is invalid.',

        'due_date.required' => 'Please select a due date.',
        'due_date.date' => 'The due date is not a valid date.',
    ];

    public function resetForm()
    {
        $this->reset([
            'title',
            'description',
            'category_id',
            'story_point_id',
            'estimated_hour_id',
            'due_date',
            'status',
            'notes',
        ]);
    }

    public function save()
    {
        $validated = $this->validate();

        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'story_point_id' => $validated['story_point_id'],
            'estimated_hour_id' => $validated['estimated_hour_id'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'order' => 0, // create selalu 0
            'user_id' => Auth::id(),
            'project_id' => $this->project->id,
        ]);

        session()->flash('success', 'Tasks successfully created.');

        $this->resetForm();
        $this->modal('add-task')->close();
    }

    public function edit(Task $task)
    {
        $this->task_id = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->category_id = $task->category_id;
        $this->story_point_id = $task->story_point_id;
        $this->estimated_hour_id = $task->estimated_hour_id;
        $this->due_date = Carbon::parse($task->due_date)->format('Y-m-d');
        $this->status = $task->status;
        $this->notes = $task->notes;
        $this->order = $task->order;

        $this->is_edit = true;

        $this->modal('add-task')->show();
    }

    public function update()
    {
        $validated = $this->validate();

        if (! $this->task_id) {
            return;
        }

        $task = Task::where('id', $this->task_id)
            ->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'story_point_id' => $validated['story_point_id'],
                'estimated_hour_id' => $validated['estimated_hour_id'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'],
                'notes' => $validated['notes'],
                'order' => $this->order, // tetap pakai order lama
            ]);

        $this->is_edit = false;
        $this->task_id = null;
        $this->modal('add-task')->close();

        session()->flash('success', 'Task successfully updated.');

    }

    public function delete(Task $task)
    {
        $this->task_to_delete_id = $task->id;
        $this->modal('delete-task')->show();
    }

    public function confirmDelete()
    {
        $task = Task::where('id', $this->task_to_delete_id)->delete();
        $this->modal('delete-task')->close();
        session()->flash('success', 'Task successfully deleted.');
    }

    public function auto_sort()
    {
        $tasks = Task::with(['category', 'story_point', 'estimated_hour'])
            ->where('project_id', $this->project->id)
            ->get();

        if ($tasks->isEmpty()) {
            session()->flash('error', 'No tasks available to sort.');

            return;
        }

        $payload = [
            'tasks' => $tasks->map(function ($task) {
                return [
                    'id' => (string) $task->id,
                    'title' => (string) $task->title,
                    'description' => (string) $task->description,
                    'user_id' => (string) $task->user_id,
                    'category' => (string) $task->category->name ?? null,
                    'story_point' => (int) $task->story_point->value ?? 0,
                    'estimated_hour' => (int) $task->estimated_hour->value ?? 0,
                    'due_date' => (string) Carbon::parse($task->due_date)->format('Y-m-d'),
                    'created_at' => (string) Carbon::parse($task->created_at)->format('Y-m-d'),
                ];
            })->values()->toArray(),
        ];

        $response = Http::timeout(30)
            ->asJson()
            ->post('http://host.docker.internal:3030/api/sort-tasks', $payload);

        if (! $response->successful()) {
            session()->flash('error', 'AI sorting service is unavailable.');

            return;
        }

        $sorted_tasks = $response->json('tasks');

        foreach ($sorted_tasks as $item) {
            Task::where('id', $item['id'])
                ->update([
                    'order' => $item['order'],
                    'priority' => $item['priority'],
                ]);
        }

        session()->flash('success', 'Tasks successfully reordered using AI.');

        $this->modal('auto-sort-task')->close();
    }

    public function toggleColumn($column)
    {
        if (isset($this->visible_columns[$column])) {
            $this->visible_columns[$column] = ! $this->visible_columns[$column];
        }
    }
};
