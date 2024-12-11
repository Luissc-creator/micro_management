@extends('operator.layout')
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <h3>📋 Ongoing Tasks</h3>
            <div>
                <button class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                    + New Task
                </button>
                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#importBatchTaskModal">
                    📤 Import Batch
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="taskTable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr id="task-row-{{ $task->id }}">
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->task_description }}</td>
                            <td>
                                @switch($task->task_priority)
                                    @case('high')
                                        <span class="badge bg-danger">🔴</span>
                                    @break

                                    @case('medium')
                                        <span class="badge bg-warning">🟡</span>
                                    @break

                                    @case('low')
                                        <span class="badge bg-success">🟢</span>
                                    @break
                                @endswitch
                                {{ $task->task_priority }}
                            </td>
                            <td>
                                <span
                                    class="badge 
@if ($task->status === 'in_progress') bg-primary @elseif($task->status === 'completed') bg-info 
@elseif($task->status === 'cancelled' || $task->status === 'overdue') bg-danger @else bg-warning text-secondary @endif">
                                    {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td>{{ $task->task_deadline }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-success complete-btn" data-id="{{ $task->id }}">✅</button>
                                    <button class="btn btn-warning pause-btn" data-id="{{ $task->id }}">⏸️</button>
                                    <button class="btn btn-warning start-btn" data-id="{{ $task->id }}">▶️</button>
                                    <button class="btn btn-danger cancel-btn" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-id="{{ $task->id }}">❌</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
