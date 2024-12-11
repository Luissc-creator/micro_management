<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'task_name',
        'task_description',
        'task_priority',
        'task_deadline',
        'operator_id', // Assuming an operator is associated with the task
        'project_id', // Assuming a task is associated with a project
    ];

    // Optionally, define relationships
    public function operator()
    {
        return $this->belongsTo(Operator::class); // Adjust based on your operator model
    }

    public function project()
    {
        return $this->belongsTo(Project::class); // Adjust based on your project model
    }

    public function subTasks()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }
}