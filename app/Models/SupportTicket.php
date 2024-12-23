<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ['client_id', 'operator_id', 'subject', 'description', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }
}
