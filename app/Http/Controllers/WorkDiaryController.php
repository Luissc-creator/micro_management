<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class WorkDiaryController extends Controller
{
    //
    public function getWorkDiaryData($projectId)
    {
        $activityLogs = ActivityLog::where('project_id', $projectId)->get();  // Fetch activity logs
        // $dailyUpdates = DailyUpdate::where('project_id', $projectId)->get(); // Fetch daily updates

        logger('activitylog: '.json_encode($activityLogs));
        return response()->json([
            'activityLogs' => $activityLogs,
            // 'dailyUpdates' => $dailyUpdates
        ]);
    }

}