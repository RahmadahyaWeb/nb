<?php

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $name;

    public $description;

    public $start_date;

    public $end_date;

    public $editingProjectId = null; // 1️⃣ ID project yang sedang diedit

    #[Computed()]
    public function projects()
    {
        return Project::with('user')
            ->where('user_id', Auth::id())
            ->paginate();
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
    ];

    protected $messages = [
        'name.required' => 'Please enter a name for the task.',
        'name.string' => 'The name must be a valid text.',
        'name.max' => 'The name cannot exceed 255 characters.',
        'description.required' => 'Please provide a description for the task.',
        'description.string' => 'The description must be valid text.',
        'start_date.required' => 'Please select a start date.',
        'start_date.date' => 'The start date is not a valid date.',
        'end_date.required' => 'Please select a end date.',
        'end_date.date' => 'The end date is not a valid date.',
    ];

    // 2️⃣ EDIT METHOD
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        $this->editingProjectId = $project->id;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;

        $this->modal('add-project')->show();
    }

    // 3️⃣ SAVE METHOD (CREATE OR UPDATE)
    public function save()
    {
        $validated = $this->validate();

        if ($this->editingProjectId) {
            // UPDATE
            $project = Project::findOrFail($this->editingProjectId);
            $project->update($validated);
        } else {
            // CREATE
            Project::create([
                ...$validated,
                'user_id' => Auth::id(),
            ]);
        }

        $this->resetForm();
        $this->modal('add-project')->close();
    }

    public $deletingProjectId = null;

    // 1️⃣ OPEN DELETE MODAL
    public function delete($id)
    {
        $this->deletingProjectId = $id;
        $this->modal('delete-project')->show();
    }

    // 2️⃣ CONFIRM DELETE
    public function confirmDelete()
    {
        if ($this->deletingProjectId) {
            Project::where('id', $this->deletingProjectId)
                ->where('user_id', Auth::id())
                ->delete();
        }

        $this->deletingProjectId = null;
        $this->modal('delete-project')->close();
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'start_date', 'end_date', 'editingProjectId']);
    }
};
