<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class TaskDeadlineReminderMail extends Mailable
{
    public $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function build()
    {
        return $this->subject('Task Deadline Approaching')
            ->view('emails.task_deadline_reminder');
    }
}
