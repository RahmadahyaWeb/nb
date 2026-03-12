<?php

use App\Models\StoryPoint;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Computed()]
    public function storyPoints()
    {
        $story_points = StoryPoint::paginate(5);

        return $story_points;
    }
};
