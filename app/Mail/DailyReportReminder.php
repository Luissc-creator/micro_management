<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyReportReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $operator;

    public function __construct($operator)
    {
        $this->operator = $operator;
    }

    public function build()
    {
        return $this->subject('Daily Report Reminder')
            ->view(view: 'emails.daily_report_reminder')
            ->with(['operator' => $this->operator]);
    }
}
