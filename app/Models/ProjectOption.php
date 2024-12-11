<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectOption extends Model
{
    protected $fillable = [
        'project_id',
        'notification_recipients',
        'email_template',
        'push_template'
    ];

    protected $casts = [
        'notification_recipients' => 'array',  // Automatically casts to array
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
