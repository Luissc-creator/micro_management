<?php

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class TaskCompletionNotification extends Notification
{
    use Queueable;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];  // You can add 'database' if you want to store notifications in the database
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Task Completion Alert: ' . $this->task->title)
                    ->line('Task "' . $this->task->title . '" has been marked as "' . $this->task->status . '".')
                    ->action('View Task Details', url('/tasks/' . $this->task->id))
                    ->line('Please review the task at your earliest convenience.');
    }

    // Optional: To store in database or other channels like SMS, etc.
}
