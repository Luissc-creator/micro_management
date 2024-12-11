<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ['client_id', 'operator_id', 'subject', 'description', 'status'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
