<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Task;
use App\Models\DailyReport;
use App\Models\Operator;
use App\Models\User;
use App\Notifications\TaskCompletionNotification;

class OperatorController extends Controller
{
    //
    public function dashboard()
    {
        $operatorId = session('operator_id');
        // Fetch active projects where this operator is assigned
        $activeProjectsCount = Project::whereJsonContains('operator_ids', $operatorId)
            ->where('status', 'active')
            ->count();
        $activeProjects = Project::whereJsonContains('operator_ids', $operatorId)
            ->where('status', 'active')->get()->map(function ($project) {
                $project->progress = $project->tasks()->where('status', 'completed')->count()
                    / max($project->tasks()->count(), 1) * 100;
                $project->deadline_in_days = (int)(-Carbon::parse($project->deadline)->diffInDays(Carbon::now()));
                return $project;
            });;
        $taskCount = Task::where('operator_id', $operatorId)->count();
        $communicationCount = Communication::where('receiver_id', $operatorId)->count();
        return view('operator.dashboard', compact('activeProjects', 'taskCount', 'communicationCount'));
    }

    public function area($currentProjectIndex = 0)
    {
        $operatorId = session('operator_id');
        $operator = Operator::where('id', operator: $operatorId)->first();
        $activeProjects = Project::whereJsonContains('operator_ids', $operatorId)
            ->where('status', 'active') // Only active projects
            ->get();
        if (!$activeProjects)
            return back()->with('error', 'not available');
        foreach ($activeProjects as $project) {
            $createdAt = Carbon::parse($project->created_at);
            $deadline = Carbon::parse($project->deadline);
            $now = Carbon::now();
            $project->hoursWorked = $createdAt->diffInHours($now);
            $project->remainedDays = $now->diffInDays($deadline);
            $projectDuration = $createdAt->diffInDays($deadline);
            $project->progress = intval(100 - $project->remainedDays / $projectDuration * 100);
        }
        $currentProject = $activeProjects[$currentProjectIndex];

        $tasks = Task::where('project_id', $currentProject->id)
            // ->where('operator_id', $operatorId)
            ->get();
        $total_task_count = $tasks->count();
        // $completed_tasks_count = Task::where('project_id', $currentProject->id)
        //     ->where('operator_id', $operatorId)->where('status', 'completed')->count();
        // $project_progress = $total_task_count == 0 ? 0 : $completed_tasks_count * 100 / $total_task_count;

        return view('operator.area', compact('activeProjects', 'currentProjectIndex', 'tasks', 'operator'));
    }

    public function submitDailyReport(Request $request)
    {
        logger('daily report:  ' . $request->project_id);
        $request->validate([
            'report_content' => 'required|string',
        ]);

        $operatorId = session('operator_id') ?? '';  // Assuming you use authentication
        $today = now()->format('Y-m-d');

        // Insert or update the daily report
        DailyReport::updateOrCreate(
            ['operator_id' => $operatorId, 'report_date' => $today, 'project_id' => $request->project_id],
            ['report_content' => $request->report_content]
        );

        $operator = Operator::where('id', $operatorId)->first();
        // Clear missed report status if it's marked
        $operator->update(['missed_daily_report' => false]);

        return back()->with('success', 'Daily report submitted successfully!');
    }


    public function submitTaskForReview(Task $task)
    {
        $task->status = 'under_review';
        $task->save();

        // Notify the admin that the task is submitted for review
        $admin = User::where('role', 'admin')->first();  // Get the administrator or project manager
        $admin->notify(new TaskCompletionNotification($task));
    }
}
