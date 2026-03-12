<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryPoint extends Model
{
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'story_point_id');
    }
}
