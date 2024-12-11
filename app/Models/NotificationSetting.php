<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'event_type',
        'email_recipients',
        'status',
        'frequency',
        'custom_subject',
        'custom_message',
        'project_id'
    ];
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
