<?php

namespace App\Http\Controllers;

use App\Models\NotificationRecipient;
use Illuminate\Http\Request;

class NotificationRecipientsController extends Controller
{
    public function update(Request $request)
    {
        foreach ($request->recipients as $userId => $events) {
            foreach ($events as $event => $value) {
                NotificationRecipient::updateOrCreate(
                    ['user_id' => $userId, 'event' => $event],
                    ['email_notification' => isset($value)]
                );
            }
        }

        return back()->with('success', 'Notification recipients updated successfully.');
    }
}
