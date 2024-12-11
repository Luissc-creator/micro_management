<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class DailyReport extends Model
{
    use HasFactory;

    protected $fillable = ['operator_id', 'project_id', 'report_date', 'report_content'];

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function operatorHasReportToday($operatorId)
    {
        return self::where('operator_id', $operatorId)
            ->whereDate('report_date', Carbon::today())
            ->exists();
    }
}
