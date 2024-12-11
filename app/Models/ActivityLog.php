<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'action',
    ];

    /**
     * Define a polymorphic relation for the activity log.
     */
    /**
     * Define the user who performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper function to record an activity log.
     */
    // public static function record($userId, $action, $description, $loggable)
    // {
    //     return self::create([
    //         'user_id' => $userId,
    //         'action' => $action,
    //         'description' => $description,
    //         'loggable_type' => get_class($loggable),
    //         'loggable_id' => $loggable->id
    //     ]);
    // }
}