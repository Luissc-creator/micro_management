<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use App\Models\Project;
use App\Models\User;

class AdminController extends Controller
{
    //
    public function showAdminDashboard()
    {
        $activityLogs = ActivityLog::latest()->take(5)->get();
        return view('admin/dashboard', compact('activityLogs'));
    }

    public function showNotificationSettings()
    {
        logger('notification setting function entered');
        $events = ['task_completed', 'new_message', 'new_task_assigned'];  // Example events
        $notificationSettings = NotificationSetting::all()->pluck('receive_email', 'event');

        return view('admin.notification_settings', compact('events', 'notificationSettings'));
    }

    public function saveNotificationSettings(Request $request)
    {
        foreach ($request->notifications as $event => $receive_email) {
            NotificationSetting::updateOrCreate(
                ['event' => $event],
                ['receive_email' => $receive_email]
            );
        }

        return redirect()->back()->with('success', 'Notification settings updated.');
    }

    public function projectReports()
    {
        // Retrieve all projects with additional data as needed (e.g., progress, tasks)
        $projects = Project::all(); // You can modify this query as needed

        return view('admin.reports.project', compact('projects'));
    }

    public function showProject($id)
    {
        $project = Project::findOrFail($id); // Retrieve the project by ID

        // Pass the project data to the view
        return view('admin.projects.show', compact('project'));
    }

    public function userReports()
    {
        $users = User::paginate(10); // Fetch users with pagination
        return view('admin.reports.user', compact('users'));
    }
}
