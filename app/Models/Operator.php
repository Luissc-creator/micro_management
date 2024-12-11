<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $fillable = ['user_id', 'operator_specific_field'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'operator_project');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function attachments()
    {
        return $this->morphMany(FileAttachment::class, 'attachable');
    }
}
