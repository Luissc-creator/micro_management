<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Events\TaskSubmittedForReview;
use Illuminate\Support\Carbon;
use App\Models\Operator;

class TaskController extends Controller
{
    // Store a new task
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'task_name' => 'required|string|max:255',
            'task_description' => 'required|string',
            'task_priority' => 'required|in:low,medium,high',
            'task_deadline' => 'required|date',
        ]);

        // Create the new task
        $task = Task::create([
            'task_name' => $validated['task_name'],
            'task_description' => $validated['task_description'],
            'task_priority' => $validated['task_priority'],
            'task_deadline' => $validated['task_deadline'],
            'operator_id' => Session::get('operator_id'), // Retrieve the operator_id from session
            'project_id' => $request->project_id, // Assuming project_id is passed in the request
        ]);
        ProjectController::updateProjectDeadline($task->project->id);
        // Return response (you can adjust this for your needs)
        return redirect()->back()->with('success', 'Task created successfully!');
    }

    public function complete($taskId)
    {
        $task = Task::where('id', $taskId)->first();
        $task->status = 'completed';
        $task->save();
        //   /      $task->update(['status' => 'Completed']);
        return response()->json(['message' => 'Task marked as completed!' . Task::where('id', $taskId)->first()->status]);
    }

    public function pause($taskId)
    {
        $task = Task::where('id', $taskId)->first();
        $task->status = $task->status == 'pending_client' ? 'in_progress' : 'pending_client';
        $task->save();
        $message = $task->status == 'Paused' ? 'Task paused!' : 'Task resumed!';
        return response()->json(['message' => $message, 'status' => $task->status]);
    }

    public function cancel(Request $request, $taskId)
    {
        logger('task cancel function entered');
        if ($request->password !== 'password123')
            return response()->json(['message' => 'Password is not match']);
        $task = Task::where('id', $taskId)->first();
        $task->delete();
        return response()->json(['success' => 'successfuly deleted']);
    }

    public function underReview($taskId)
    {
        $task = Task::where('id', $taskId)->first();
        $task->status = 'under_review';
        $task->save();
        event(new TaskSubmittedForReview($task));
        return response()->json(['message' => 'Task is under Client\'s review', 'status' => $task->status]);
    }

    public function status(Request $request, $taskId)
    {
        $task = Task::where('id', $taskId)->first();
        $task->status = $request->status;
        $task->save();
        return response()->json(['success' => 'task status is changed!']);
    }

    public function importTasks(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt|max:2048', // Validate the file
        ]);

        $file = $request->file('file');
        $tasks = [];
        $lineNumber = 1;

        // Read the file line by line
        $fileHandle = fopen($file, 'r');
        while (($line = fgets($fileHandle)) !== false) {
            if ($lineNumber === 1) {
                // Skip the header row
                $lineNumber++;
                continue;
            }

            $data = explode("\t", trim($line)); // Split by tabs

            if (count($data) !== 5) {
                return back()->withErrors(['file' => "Invalid format on line $lineNumber."]);
            }

            $tasks[] = [
                'title'       => $data[0],
                'description' => $data[1],
                'deadline'    => Carbon::parse($data[2]),
                'priority'    => $data[3],
                'assigned_to' => $data[4],
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            $lineNumber++;
        }

        fclose($fileHandle);

        // Bulk insert tasks into the database
        Task::insert($tasks);

        return redirect()->back()->with('success', 'Tasks imported successfully.');
    }


    public function show($id)
    {
        $task = Task::with(['project', 'operator.user'])->findOrFail($id);
        return view('admin.tasks.show', compact('task'));
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('projects.show', $task->project_id)->with('success', 'Task deleted successfully.');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $operators = Operator::with('user')->get(); // Assuming 'user' is the relationship
        return view('admin.tasks.edit', compact('task', 'operators'));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'task_name' => 'required|string|max:255',
            'description' => 'required|string',
            'operator_id' => 'nullable|exists:operators,id', // Ensure operator exists if provided
            'deadline' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Find the task by ID
        $task = Task::findOrFail($id);

        // Update task with validated data
        $task->update([
            'task_name' => $validatedData['task_name'],
            'description' => $validatedData['description'],
            'operator_id' => $validatedData['operator_id'],
            'deadline' => $validatedData['deadline'],
            'status' => $validatedData['status'],
        ]);

        // Redirect to a relevant page with a success message
        return redirect()
            ->route('tasks.show', $task->id)
            ->with('success', 'Task updated successfully.');
    }
}
