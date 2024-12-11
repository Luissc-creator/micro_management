<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Operator;
use App\Models\Client;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function operator()
    {
        return $this->hasOne(Operator::class);
    }

    public function isNotifiedForEvent($event)
    {
        return $this->notificationRecipients()->where('event', $event)->exists();
    }

    public function notificationRecipients()
    {
        return $this->hasMany(NotificationRecipient::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Communication::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Communication::class, 'receiver_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
