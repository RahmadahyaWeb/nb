<?php

use App\Models\EstimatedHour;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Computed()]
    public function EstimatedHours()
    {
        $estimated_hours = EstimatedHour::paginate(5);

        return $estimated_hours;
    }

};
