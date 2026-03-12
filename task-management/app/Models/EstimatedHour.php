<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimatedHour extends Model
{
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class, 'estimated_hour_id');
    }
}
