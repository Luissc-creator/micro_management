<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationRecipient extends Model
{
    protected $fillable = ['user_id', 'event', 'email_notification'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
