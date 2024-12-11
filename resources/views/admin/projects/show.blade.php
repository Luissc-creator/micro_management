<!-- resources/views/admin/projects/show.blade.php -->

@extends('admin.layout')

@section('title', 'Project Details')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Project Card -->
                <div class="card shadow-sm border-light">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <h3>{{ $project->name }} - Project Details</h3>
                        <a href="{{ route('admin.projectReports') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Projects
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Project Information -->
                        <div class="mb-4">
                            <h4 class="mb-3 text-primary">Project Information</h4>
                            <p><strong>Status:</strong> <span
                                    class="badge bg-{{ $project->status == 'Completed' ? 'success' : 'warning' }}">{{ $project->status }}</span>
                            </p>
                            <p><strong>Progress:</strong> {{ $project->progress }}%</p>
                            <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($project->deadline)->format('d M, Y') }}
                            </p>
                            <p><strong>Hours Worked:</strong> {{ $project->hours_worked }} hours</p>
                        </div>

                        <!-- Project Progress Bar -->
                        <div class="progress my-4">
                            <div class="progress-bar" role="progressbar" style="width: {{ $project->progress }}%"
                                aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $project->progress }}%
                            </div>
                        </div>

                        <!-- Tasks Section -->
                        <h4 class="my-3 text-info">Project Tasks</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Status</th>
                                        <th>Assigned To</th>
                                        <th>Deadline</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->tasks as $task)
                                        <tr>
                                            <td>{{ $task->task_name }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $task->status == 'Completed' ? 'success' : 'warning' }}">
                                                    {{ $task->status }}
                                                </span>
                                            </td>
                                            <td>{{ $task->operator_id ? $task->operator->user->name : 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d M, Y') }}</td>
                                            <td>
                                                <a href="{{ route('tasks.show', $task->id) }}"
                                                    class="btn btn-info btn-sm">View Task</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Project Files Section -->
                        <h4 class="my-4 text-warning">Project Files</h4>
                        <ul class="list-unstyled">
                            {{-- @foreach ($project->files as $file)
                                <li>
                                    <a href="{{ asset('storage/' . $file->path) }}" class="text-decoration-none"
                                        target="_blank">
                                        <i class="fas fa-file"></i> {{ $file->filename }}
                                    </a>
                                </li>
                            @endforeach --}}
                        </ul>

                        <!-- Add New Task Button -->
                        {{-- <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
                            class="btn btn-primary mt-3">Add New Task</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
