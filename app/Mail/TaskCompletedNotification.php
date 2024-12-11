<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskCompletedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Task  $task
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;  // Pass the task instance to the Mailable
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Task Completed: ' . $this->task->title)
            ->view('emails.task_completed') // View for the email content
            ->with([
                'taskTitle' => $this->task->title,
                'taskDescription' => $this->task->description,
                'taskCompletedAt' => $this->task->completed_at,
                'taskAssignee' => $this->task->assignee->name ?? 'Not Assigned',
                'taskCompletedBy' => $this->task->completed_by->name ?? 'unknown'
            ]);
    }
}
