<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Task;

class DeadlineMissedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $project;

    /**
     * Create a new notification instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->project = $task->project; // Assuming Task belongs to Project
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Send via email and store in DB
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Deadline Missed: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('The deadline for the task "' . $this->task->title . '" in project "' . $this->project->name . '" has been missed.')
            ->action('View Task', url('/tasks/' . $this->task->id))
            ->line('Please take the necessary actions.');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'message' => 'The deadline for the task "' . $this->task->title . '" has been missed.',
        ];
    }
}
