<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;
use App\Models\Operator;
use App\Models\NotificationTemplate;
use Illuminate\Support\Facades\Mail;
use App\Models\NotificationRecipient;
use App\Mail\CustomNotificationMail;
use App\Models\ActivityLog;
use App\Exports\ProjectExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Task;
use Illuminate\Support\Carbon;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // List all projects for the admin
        $projects = Project::with('client.user')->get();
        logger('clients:   ' . json_encode($projects));
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        // Fetch clients and operators for project assignment
        $clients = Client::with('user')->get();
        $operators = Operator::with('user')->get();
        return view('admin.projects.create', compact('clients', 'operators'));
    }

    public function store(Request $request)
    {
        // Validate and store new project
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'client_id' => 'required|exists:clients,id',
            'operator_ids' => 'required|array',
            'deadline' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $project = Project::create($request->all());

        // $recipients = NotificationRecipient::where('event', 'project_created')->get();

        // foreach ($recipients as $recipient) {
        //     $template = NotificationTemplate::where('event', 'project_created')->first();
        //     Mail::to($recipient->user->email)->send(new CustomNotificationMail($template->subject, $template->body, $project));
        // }

        ActivityLog::create([
            'user_id' => session('user_id'),
            'action' => 'project created',
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function edit($id)
    {
        // Fetch the project by its ID
        $project = Project::findOrFail($id);

        // Fetch all clients and operators for selection dropdowns
        $clients = Client::all();
        $operators = Operator::all();

        // Pass the project and users data to the edit view
        return view('admin.projects.edit', compact('project', 'clients', 'operators'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'operators' => 'required|array',
            'operators.*' => 'exists:operators,id',
            'deadline' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        // Find the project by ID
        $project = Project::findOrFail($id);

        // Update the project's basic details
        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'client_id' => $request->client_id,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
        ]);

        // Sync the assigned operators
        $project->operators()->sync($request->operators);

        // Redirect back with success message
        return redirect()->route('projects.index', $id)->with('success', 'Project updated successfully!');
    }

    public function destroy($project_id)
    {
        // Delete the project
        Project::where('id', $project_id)->first()->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    public function archivePage()
    {
        // Fetch only active projects
        $activeProjects = Project::where('status', 'active')->get();

        // Fetch archived projects
        $archivedProjects = Project::where('status', 'archived')->get();

        // Return the view with the list of active projects
        return view('admin.projects.archive', compact('activeProjects', 'archivedProjects'));
    }

    public function archive($id)
    {
        $project = Project::findOrFail($id);

        // Check if project is already archived
        if ($project->status === 'archived') {
            return redirect()->back()->with('error', 'Project is already archived.');
        }

        // Update the project status to 'archived'
        $project->status = 'archived';
        $project->save();

        // Notify the admin that the project has been archived
        return redirect()->back()->with('success', 'Project has been archived successfully.');
    }

    public function unarchive($id)
    {
        $project = Project::findOrFail($id);

        if ($project->status === 'archived') {
            // Unarchive the project
            $project->status = 'active';
            $project->save();

            return redirect()->back()->with('success', 'Project unarchived successfully!');
        }

        return redirect()->back()->with('error', 'Project is not archived.');
    }

    public function exportProjects()
    {
        return Excel::download(new ProjectExport, 'projects.xlsx');
    }

    public static  function updateProjectDeadline($projectId)
    {
        // Get the latest task deadline
        $latestTaskDeadline = Task::where('project_id', $projectId)->max('deadline');

        // Count open requests/tickets and calculate buffer time
        $openRequestsCount = Request::where('project_id', $projectId)
                                    ->where('status', 'pending_client')
                                    ->count();
        $bufferTime = $openRequestsCount * 2; // 2 days per open request

        // Calculate the final project deadline
        $finalDeadline = Carbon::parse($latestTaskDeadline)->addDays($bufferTime);

        // Update the project deadline
        $project = Project::find($projectId);
        $project->update([
            'deadline' => $finalDeadline
        ]);
    }
}