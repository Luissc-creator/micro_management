<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $fillable = ['type', 'task_id', 'client_id', 'operator_id', 'message', 'status', 'response_received_at'];

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function responses()
    {
        return $this->hasOne(Response::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function isBlocked()
    {
        // For example, if the request is older than 24 hours and no response
        if (!$this->response_received_at && $this->created_at->diffInHours(now()) >= 24) {
            return true;
        }

        return false;
    }

    public function markAsBlocked()
    {
        $this->status = 'blocked';
        $this->save();
    }

    public function markAsUnblocked()
    {
        $this->status = false;
        $this->response_received_at = now();
        $this->save();
    }

    // Calculate the total blockage time in days
    public function getBlockageDays()
    {
        if ($this->status == 'blocked') {
            return now()->diffInDays($this->request_sent_at);
        }

        return $this->response_received_at ? $this->response_received_at->diffInDays($this->request_sent_at) : 0;
    }
}
