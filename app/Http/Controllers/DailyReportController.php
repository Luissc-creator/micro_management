<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;  // Import your DailyReport model
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function index($id)
    {
        // Fetch all daily reports or customize this query as needed
        $dailyReports = DailyReport::where('project_id',$id)->get();

        // Return the view with daily reports data
        return view('daily-reports.index', compact('dailyReports'));
    }
}