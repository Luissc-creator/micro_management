<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRequest;
use App\Models\Response;
use App\Models\Task;
use App\Events\OperatorRequestSent;

class UserRequestController extends Controller
{
    public function store(Request $request)
    {
        // Create a new request from the operator to the client
        logger('UserRequestFunction Entered!');
        $validated = $request->validate([
            'type' => 'required',
            'task_id' => 'nullable|exists:tasks,id',
            'client_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);
        $validated['operator_id'] = session('operator_id'); // The logged-in operator
        $validated['status'] = 'pending';
        $userRequest = UserRequest::create($validated);

        $task = Task::where('id', $request->task_id)->first();
        $task->status = 'pending_client';
        $task->save();

        $project = $task->project;
        $project->request_sent_at = now();
        $project->project_status = 'pending_client';
        $project->save();
        logger('userrequest:::' . json_encode($userRequest));
        event(new OperatorRequestSent($userRequest, $project));

        // Optionally send a notification
        // Notification::send($client, new RequestNotification($validated['message']));
        return response()->json([
            'success' => true,
            'message' => 'Client request submitted successfully!',
        ]);
    }

    public function show(Request $request, $id)
    {
        $clientRequest = UserRequest::findOrFail($id);

        // Allow client to respond to the request


        return view('requests.show', compact('clientRequest'));
    }

    public function showAll(Request $request)
    {
        logger('entered function show_all');
        $clientRequests = UserRequest::get();
        logger('dlsfldlf:::' . json_encode($clientRequests));

        return response()->json([
            'success' => true,
            'message' => 'Requests fetched successfully.',
            'data' => $clientRequests,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $clientRequest = UserRequest::findOrFail($id);
        $clientRequest->status = 'completed'; // Mark the request as completed
        $clientRequest->save();
        return back()->with('success', 'successful');
        //        return redirect()->route('projects.show', $clientRequest->task->project_id);
    }


    // Client responds to the request
    public function respondToRequest(Request $request, $requestId)
    {
        $validatedData = $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:2048|mimes:jpg,png,pdf,docx',
        ]);

        // Handle file upload if provided
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('responses');
        }

        logger('request)id::::' . $requestId);
        $userRequest = UserRequest::where('id', $requestId)->first();
        $userRequest->status = 'completed';
        $userRequest->save();
        // Create the response
        Response::create([
            'user_request_id' => $requestId,
            'client_id' => session('client_id'), // The client responding
            'message' => $validatedData['message'],
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Response submitted successfully!');
    }
}
