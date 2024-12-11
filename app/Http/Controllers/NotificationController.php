<?php

namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Mail;
use App\Models\Task;
use App\Mail\TaskCompletedNotification;
use App\Models\ProjectOption;

abstract class Controller
{
    public function sendTaskCompletedNotification(Task $task)
    {
        $projectOptions = ProjectOption::where('project_id', $task->project_id)->first();

        // Get recipients
        $recipients = $projectOptions->notification_recipients ?? ['admin@example.com'];

        // Send email notifications
        foreach ($recipients as $recipient) {
            Mail::to($recipient)->send(new TaskCompletedNotification($task, $projectOptions->email_template));
        }

        // Handle push notifications similarly
    }
}
