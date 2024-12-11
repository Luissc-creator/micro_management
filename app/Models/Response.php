<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserRequest;

class Response extends Model
{
    protected $fillable = ['user_request_id', 'client_id', 'message', 'file_path'];

    public function request()
    {
        return $this->belongsTo(UserRequest::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
