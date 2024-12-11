<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientNonResponseNotification;

class CheckClientResponse extends Command
{
    // Command name and description
    protected $signature = 'check:client-response';
    protected $description = 'Check if clients have not responded to operator requests within 24 hours';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get the current time minus 24 hours
        $deadlineTime = Carbon::now()->subHours(24);

        // Find all projects where the request was sent over 24 hours ago and the client hasn't responded yet
        $projects = Project::where('request_sent_at', '<=', $deadlineTime)
            ->where('project_status', 'pending_client')
            ->get();

        // For each project that meets the criteria, send a notification to the client and operator
        foreach ($projects as $project) {
            // Send notification to the client and operator
            $project->project_status = 'blocked';
            $project->save();
            Mail::to($project->client->email)->send(new ClientNonResponseNotification($project));

            // Optionally, notify the operator as well
            Mail::to($project->operator->email)->send(mailable: new ClientNonResponseNotification($project));

            // Log the action
            $this->info("Notification sent for project: " . $project->id);
        }

        return 0;
    }
}
