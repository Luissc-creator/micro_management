<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Mail\TaskDeadlineReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskDeadlineReminders extends Command
{
    // Command signature
    protected $signature = 'tasks:send-deadline-reminders';

    // Command description
    protected $description = 'Send reminders for tasks approaching their deadlines.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get current date and time
        $currentDate = Carbon::now();

        // Get tasks with deadlines within the next 24 hours
        $tasks = Task::where('deadline', '>=', $currentDate)
            ->where('deadline', '<=', $currentDate->copy()->addHours(24))
            ->get();

        foreach ($tasks as $task) {
            // Get the assigned operator
            $operator = $task->operator; // Assuming Task model has 'operator' relationship

            // Send email notification
            Mail::to($operator->email)->send(new TaskDeadlineReminderMail($task));

            $this->info("Reminder sent to {$operator->email} for task: {$task->title}");
        }

        $this->info('Task deadline reminders sent successfully!');
    }
}
