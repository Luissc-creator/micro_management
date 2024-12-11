<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'description', 'client_id', 'operator_ids', 'deadline', 'priority', 'is_blocked', 'blocked_at', 'blocked_days',];
    // Operators will likely be stored as an array of IDs, use a mutator to cast them:
    // protected $casts = [
    //     'operator_ids' => 'array',
    // ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function operators()
    {
        return $this->belongsToMany(Operator::class, 'operator_project'); // Pivot table for many-to-many
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function notificatonSettings()
    {
        return $this->hasMany(NotificationSetting::class, 'notification_setting_id');
    }

    public function setOperatorIdsAttribute($value)
    {
        // Ensure it's stored as an array (even if it's passed as a string)
        $this->attributes['operator_ids'] = json_encode(is_array($value) ? $value : json_decode($value, true));
    }

    public function projectBriefing()
    {
        return $this->hasOne(ProjectBriefing::class);
    }
}
