<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'category_id');
    }
}
