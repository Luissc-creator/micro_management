<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksExport implements FromCollection, WithHeadings
{
    /**
     * Return a collection of tasks.
     */
    public function collection()
    {
        return Task::all(['id', 'task_name', 'task_description', 'status', 'created_at', 'updated_at']);
    }

    /**
     * Define the headings for the columns.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Status',
            'Created At',
            'Updated At',
        ];
    }
}
