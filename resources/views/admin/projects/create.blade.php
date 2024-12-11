@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container">
        <h1>{{ isset($project) ? 'Edit Project' : 'Create New Project' }}</h1>
        <form action="{{ isset($project) ? '/projects/store/' . $project->id : '/projects/store' }}" method="POST">
            @csrf
            @if (isset($project))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="title" class="form-label">Project Title</label>
                <input type="text" class="form-control" name="title" value="{{ old('title', $project->title ?? '') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Project Description</label>
                <textarea class="form-control" name="description">{{ old('description', $project->description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select class="form-select" name="client_id" required>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ isset($project) && $project->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="operator_ids" class="form-label">Assign Operators</label>
                <select class="form-select" name="operator_ids[]" multiple required>
                    @foreach ($operators as $operator)
                        <option value="{{ $operator->id }}"
                            {{ isset($project) && in_array($operator->id, $project->operator_ids ?? []) ? 'selected' : '' }}>
                            {{ $operator->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" class="form-control" name="deadline"
                    value="{{ old('deadline', $project->deadline ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select class="form-select" name="priority" required>
                    <option value="low" {{ isset($project) && $project->priority == 'low' ? 'selected' : '' }}>Low
                    </option>
                    <option value="medium" {{ isset($project) && $project->priority == 'medium' ? 'selected' : '' }}>
                        Medium</option>
                    <option value="high" {{ isset($project) && $project->priority == 'high' ? 'selected' : '' }}>High
                    </option>
                </select>
            </div>

            <button type="submit"
                class="btn btn-success">{{ isset($project) ? 'Update Project' : 'Create Project' }}</button>
        </form>
    </div>
@endsection
