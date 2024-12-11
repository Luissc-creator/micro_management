<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRequest;
use App\Models\Project;
use Illuminate\Support\Carbon;
use App\Models\Task;

class ClientController extends Controller
{
    public function area($currentProjectIndex = 0)
    {
        $clientId = session('client_id');
        $activeProjects = Project::where('client_id', $clientId)
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
        }
        $currentProject = $activeProjects[$currentProjectIndex];

        $tasks = Task::where('project_id', $currentProject->id)
            ->get();
        $total_task_count = $tasks->count();
        $completed_tasks_count = Task::where('project_id', $currentProject->id)
            ->where('status', 'completed')->count();
        $project_progress = $total_task_count == 0 ? 0 : $completed_tasks_count * 100 / $total_task_count;
        logger('client_id:::' . $clientId);
        $requests = UserRequest::where('client_id', $clientId)->where('status', 'pending')->get();
        logger('requests:::: ' . json_encode($requests));
        return view('client.area', compact('activeProjects', 'currentProjectIndex', 'tasks', 'project_progress', 'requests'));
    }

    public function markTaskAsCompleted(Task $task)
    {
        $task->status = 'Completed';
        $task->completed_at = now();
        $task->save();

        // Notify the admin about task completion
        $this->notifyAdministrator($task);
    }
}
