<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Operator;
use App\Models\DailyReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportReminder;
use App\Mail\MissedDailyReportNotification;

class CheckDailyReports extends Command
{
    protected $signature = 'check:daily-reports';
    protected $description = 'Check if operators submitted daily reports';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = now()->format('Y-m-d');

        // Get all operators
        $operators = Operator::all();

        foreach ($operators as $operator) {
            // Check if the operator submitted a daily report today
            $hasReport = DailyReport::where('operator_id', $operator->id)
                                    ->where('report_date', $today)
                                    ->exists();

            if (!$hasReport) {
                // Mark the operator as having missed the daily report
                $operator->update(['missed_daily_report' => true]);

                // Notify the operator via email
                Mail::to($operator->email)->send(mailable: new MissedDailyReportNotification());

                // Log or handle further actions like adding alerts
                // Log::info("Operator {$operator->name} missed their daily report.");
            }
        }
    }

    protected function alertOperator($operator)
    {
        // Show sad face and alert on the dashboard (in a real app, store in the database)
        $this->info("Operator {$operator->name} missed the daily report.");

        // Send email reminder
        Mail::to($operator->email)->send(new DailyReportReminder($operator));
    }
}
