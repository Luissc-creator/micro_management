<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use App\Models\Project;

class NotificationSettingController extends Controller
{
    // Display Notification Settings Management Page
    public function index()
    {
        $notification_settings = NotificationSetting::all();  // Fetch all notification settings
        $projects = Project::all();
        return view('admin.notification-settings', compact('notification_settings', 'projects'));
    }

    public function create(Request $request)
    {
        // Validate input
        logger('et' . $request->custom_subject);
        $validatedData = $request->validate([
            'event_type' => 'required|string|max:255',
            'status' => 'required',
            'email_recipients' => 'required',
            'frequency' => 'required|string|max:50',
            'custom_subject' => 'required|string|max:255',
            'custom_message' => 'required|string',
            'project_id' => 'required'
        ]);
        logger('ssset:  ' . $validatedData['custom_subject']);
        // Create notification setting
        NotificationSetting::create($validatedData);

        return redirect()->back()->with('success', 'Notification created successfully!');
    }

    public function update(Request $request)
    {
        $notification = NotificationSetting::findOrFail($request->id);
        $notification->update($request->all());
        return redirect()->back()->with('success', 'Notification updated successfully!');
    }
}
