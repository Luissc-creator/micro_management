<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\User;
use App\Notifications\DeadlineMissedNotification;
use Carbon\Carbon;

class CheckMissedDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:check-missed-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for tasks with missed deadlines and notify relevant users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch tasks where deadline has passed, not completed, and not already marked as missed
        $tasks = Task::where('deadline', '<', Carbon::now())
            ->where('is_completed', false)
            ->where('deadline_missed', false)
            ->get();

        foreach ($tasks as $task) {
            // Mark the task as deadline missed
            $task->update(['deadline_missed' => true]);

            // Notify the operator assigned to the task
            $operator = $task->assignedTo; // Assuming Task has 'assignedTo' relationship
            if ($operator) {
                $operator->notify(new DeadlineMissedNotification($task));
            }

            // Notify the project administrators
            $project = $task->project; // Assuming Task belongs to Project
            if ($project) {
                $administrators = $project->administrators; // Define relationship
                foreach ($administrators as $admin) {
                    $admin->notify(new DeadlineMissedNotification($task));
                }
            }

            $this->info('Notified users about missed deadline for task ID: ' . $task->id);
        }

        return 0;
    }
}
