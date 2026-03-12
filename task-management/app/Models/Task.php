<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'category_id',
        'story_point_id',
        'estimated_hour_id',
        'due_date',
        'project_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function story_point()
    {
        return $this->belongsTo(StoryPoint::class, 'story_point_id');
    }

    public function estimated_hour()
    {
        return $this->belongsTo(EstimatedHour::class, 'estimated_hour_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
