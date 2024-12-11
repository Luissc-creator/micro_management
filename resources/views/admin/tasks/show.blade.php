<!-- resources/views/admin/tasks/show.blade.php -->

@extends('admin.layout')

@section('title', 'Task Details')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Task Details Card -->
                <div class="card shadow-sm border-light">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3>Task: {{ $task->task_name }}</h3>
                        <a href="{{ route('projects.show', $task->project->id) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Project
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Task Information -->
                        <h4 class="mb-3 text-primary">Task Information</h4>
                        <p><strong>Status:</strong>
                            <span class="badge bg-{{ $task->status == 'Completed' ? 'success' : 'warning' }}">
                                {{ $task->status }}
                            </span>
                        </p>
                        <p><strong>Assigned To:</strong>
                            {{ $task->operator_id ? $task->operator->user->name : 'Not Assigned' }}
                        </p>
                        <p><strong>Deadline:</strong>
                            {{ \Carbon\Carbon::parse($task->deadline)->format('d M, Y') }}
                        </p>
                        <p><strong>Description:</strong> {{ $task->description }}</p>

                        <!-- Task Progress -->
                        <div class="progress my-4">
                            <div class="progress-bar" role="progressbar" style="width: {{ $task->progress }}%"
                                aria-valuenow="{{ $task->progress }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $task->progress }}%
                            </div>
                        </div>

                        <!-- Buttons for Actions -->
                        <div class="mt-4">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Task
                            </a>
                            {{-- <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this task?');">
                                    <i class="fas fa-trash-alt"></i> Delete Task
                                </button>
                            </form> --}}
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                {{-- <div class="card shadow-sm border-light mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h4>Comments</h4>
                    </div>
                    <div class="card-body"> --}}
                <!-- Comment Form -->
                {{-- <form action="{{ route('tasks.comment', $task->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="comment" class="form-control" rows="3" placeholder="Add a comment..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </form> --}}

                <!-- Display Comments -->
                {{-- <div class="mt-4">
                    <h5>All Comments</h5>
                    <ul class="list-group"> --}}
                {{-- @foreach ($task->comments as $comment)
                                    <li class="list-group-item">
                                        <strong>{{ $comment->user->name }}</strong> <span
                                            class="text-muted">({{ $comment->created_at->diffForHumans() }})</span>
                                        <p class="mb-0">{{ $comment->content }}</p>
                                    </li>
                                @endforeach --}}
                {{-- </ul>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
