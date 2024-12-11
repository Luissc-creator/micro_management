<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProjectExport implements FromCollection, WithHeadings, WithTitle
{
    // This method defines the data to export (e.g., all projects)
    public function collection()
    {
        return Project::all(); // Modify this query based on what data you want to export
    }

    // Optional: Set the headings for the columns in the exported Excel file
    public function headings(): array
    {
        return [
            'id',
            'title',
            'description',
            'client_id',
            'operator_ids',
            'notification_setting_ids',
            'deadline',
            'priority',
            'status',
        ];
    }

    // Optional: Set the sheet title
    public function title(): string
    {
        return 'title';
    }
}