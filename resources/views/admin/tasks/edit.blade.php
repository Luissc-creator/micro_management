<!-- resources/views/admin/tasks/edit.blade.php -->

@extends('admin.layout')

@section('title', 'Edit Task')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Edit Task</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                            @csrf

                            <!-- Task Name -->
                            <div class="mb-3">
                                <label for="task_name" class="form-label">Task Name</label>
                                <input type="text" class="form-control" id="task_name" name="task_name"
                                    value="{{ old('task_name', $task->task_name) }}" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $task->description) }}</textarea>
                            </div>

                            <!-- Assigned To -->
                            <div class="mb-3">
                                <label for="operator_id" class="form-label">Assigned To</label>
                                <select class="form-select" id="operator_id" name="operator_id">
                                    <option value="">-- Select Assignee --</option>
                                    @foreach ($operators as $operator)
                                        <option value="{{ $operator->id }}"
                                            {{ old('operator_id', $task->operator_id) == $operator->id ? 'selected' : '' }}>
                                            {{ $operator->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Deadline -->
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" class="form-control" id="deadline" name="deadline"
                                    value="{{ old('deadline', \Carbon\Carbon::parse($task->task_deadline)->format('d M, Y') ? \Carbon\Carbon::parse($task->task_deadline)->format('d M, Y') : '') }}"
                                    required>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending"
                                        {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="in_progress"
                                        {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>
                                        In Progress
                                    </option>
                                    <option value="completed"
                                        {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success w-100">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
