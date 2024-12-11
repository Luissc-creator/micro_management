<!-- resources/views/admin/reports/project.blade.php -->

@extends('admin.layout')

@section('title', 'Project Reports')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Project Report Table -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Project Reports</h3>
                    </div>
                    <div class="card-body">
                        <!-- Export Button -->
                        <a href="{{ route('projects.export') }}" class="btn btn-warning mb-3">
                            Export Projects to XLS
                        </a>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project Name</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                    <th>Deadline</th>
                                    <th>Hours Worked</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $project->title }}</td>
                                        <td>{{ $project->project_status }}</td>
                                        <td>{{ $project->progress }}%</td>
                                        <td>{{ \Carbon\Carbon::parse($project->deadline)->format('d M, Y') }}</td>
                                        <td>{{ $project->hours_worked }} hours</td>
                                        <td>
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('projects.show', $project->id) }}">View</a>
                                            <!-- You can add more action buttons here if needed -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
