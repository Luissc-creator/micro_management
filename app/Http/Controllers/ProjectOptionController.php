<?php

namespace App\Http\Controllers;

use App\Models\ProjectOption;
use Illuminate\Http\Request;

class ProjectOptionController extends Controller
{
    // Show the form to edit project options
    public function edit($projectId)
    {
        $projectOption = ProjectOption::firstOrNew(['project_id' => $projectId]);

        return view('admin.project_options.edit', compact('projectOption'));
    }

    // Update project options
    public function update(Request $request, $projectId)
    {
        $request->validate([
            'notification_recipients' => 'nullable|array',
            'notification_recipients.*' => 'email',
            'email_template' => 'nullable|string|max:255',
            'push_template' => 'nullable|string|max:255',
        ]);

        ProjectOption::updateOrCreate(
            ['project_id' => $projectId],
            [
                'notification_recipients' => $request->notification_recipients,
                'email_template' => $request->email_template,
                'push_template' => $request->push_template,
            ]
        );

        return redirect()->back()->with('success', 'Project options updated successfully.');
    }
}
