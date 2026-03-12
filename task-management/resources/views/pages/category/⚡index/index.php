<?php

use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Computed()]
    public function categories()
    {
        $categories = Category::paginate(5);

        return $categories;
    }
};
