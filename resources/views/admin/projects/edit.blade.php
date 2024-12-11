@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 800px;
            background: #fff;
            padding: 2rem;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
            /* Bootstrap primary color */
        }

        .section-header {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        label {
            color: #495057;
            font-weight: 500;
        }

        .form-control {
            border: 2px solid #ced4da;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .alert {
            font-weight: bold;
        }
    </style>

    <div class="container mt-5">
        <div class="form-container mx-auto">
            <h1 class="mb-4 text-center">Edit Project: {{ $project->title }}</h1>

            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Edit Project Form -->
            <form action="{{ route('projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Project Title Section -->
                <div class="section-header">
                    <h5>Project Information</h5>
                </div>

                <!-- Project Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Project Title</label>
                    <input type="text" class="form-control" id="title" name="title"
                        value="{{ old('title', $project->title) }}" required>
                </div>

                <!-- Project Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Project Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $project->description) }}</textarea>
                </div>

                <!-- Client Section -->
                <div class="section-header">
                    <h5>Client Details</h5>
                </div>

                <!-- Project Client -->
                <div class="mb-3">
                    <label for="client_id" class="form-label">Client</label>
                    <select class="form-control" id="client_id" name="client_id" required>
                        <option value="">Select Client</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                {{ $client->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Operators Section -->
                <div class="section-header">
                    <h5>Assign Operators & Notifications</h5>
                </div>

                <!-- Project Operators -->
                <div class="mb-3">
                    <label for="operators" class="form-label">Assign Operators</label>
                    <select class="form-control" id="operators" name="operators[]" multiple required>
                        @foreach ($operators as $operator)
                            <option value="{{ $operator->id }}"
                                {{ in_array($operator->id, $project->operators->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $operator->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Notification Recipients -->
                <div class="mb-3">
                    <label for="notification_recipients" class="form-label">Notification Recipients</label>
                    <select class="form-control" id="notification_recipients" name="notification_recipients[]" multiple
                        required>
                        @foreach ($operators as $operator)
                            <option value="{{ $operator->id }}"
                                {{ in_array($operator->id, json_decode($project->notification_recipients ?? '[]')) ? 'selected' : '' }}>
                                {{ $operator->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Deadline Section -->
                <div class="section-header">
                    <h5>Project Timeline</h5>
                </div>

                <!-- Project Deadline -->
                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline</label>
                    <input type="date" class="form-control" id="deadline" name="deadline"
                        value="{{ old('deadline', $project->deadline) }}" required>
                </div>

                <!-- Priority Section -->
                <div class="section-header">
                    <h5>Priority</h5>
                </div>

                <!-- Project Priority -->
                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-control" id="priority" name="priority" required>
                        <option value="low" {{ $project->priority == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $project->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $project->priority == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Update Project</button>
                </div>
            </form>
        </div>
    </div>

@endsection
