@php
    $layout = 'admin.layout'; // Default layout
    if (session('role') == 'operator') {
        $layout = 'operator.layout';
    } elseif (session('role') == 'client') {
        $layout = 'client.layout';
    }
@endphp

@extends($layout)
@section('content')
    <div class="container">
        <h1>Daily Reports</h1>

        <!-- Daily Reports Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Operator</th>
                    <th>Report Content</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailyReports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->operator->user->name }}</td>
                        <td>{{ $report->report_content }}</td>
                        <td>{{ $report->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <!-- Example for report status, adjust as per your logic -->
                            @if ($report->status == 'sent')
                                <span class="badge bg-success">Sent</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
