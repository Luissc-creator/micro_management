<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectBriefing extends Model
{
    protected $fillable = ['project_id', 'briefing'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
