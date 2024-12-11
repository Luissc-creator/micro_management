<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectBriefing;

class ProjectBriefingController extends Controller
{
    // Display the briefing for a specific project
    public function show($projectId)
    {
        $project = Project::where('id', $projectId)->first();
        logger('' . $project);
        $briefing = $project->projectBriefing->briefing ?? 'No briefing available for this project.';

        // Return raw HTML or partial view
        return response()->json($briefing);
    }

    // Form to edit the project briefing
    public function edit($projectId)
    {
        $project = Project::findOrFail($projectId);
        $briefing = $project->briefing;

        return view('project_briefing.edit', compact('project', 'briefing'));
    }

    // Update the project briefing
    public function update(Request $request, $projectId)
    {
        $request->validate([
            'briefing' => 'required|string',
        ]);

        $project = Project::findOrFail($projectId);
        $projectBriefing = ProjectBriefing::updateOrCreate(
            ['project_id' => $projectId],
            ['briefing' => $request->briefing]
        );

        return redirect()->route('project_briefing.show', $projectId)->with('success', 'Project briefing updated successfully.');
    }
}
