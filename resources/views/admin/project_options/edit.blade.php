@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h2>Notification Settings for Project</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('project.options.update', $projectOption->project_id) }}" method="POST">
            @csrf

            <!-- Notification Recipients -->
            <div class="mb-3">
                <label for="notification_recipients" class="form-label">Notification Recipients</label>
                @foreach (range(0, 2) as $i)
                    <input type="text" class="form-control mb-2" name="notification_recipients[]"
                        value="{{ old('notification_recipients.' . $i, $projectOption->notification_recipients[$i] ?? '') }}"
                        placeholder="Enter recipient email">
                @endforeach
            </div>

            <!-- Email Template -->
            <div class="mb-3">
                <label for="email_template" class="form-label">Email Template</label>
                <input type="text" class="form-control" name="email_template" id="email_template"
                    value="{{ old('email_template', $projectOption->email_template) }}" placeholder="Email template path">
            </div>

            <!-- Push Template -->
            <div class="mb-3">
                <label for="push_template" class="form-label">Push Template</label>
                <input type="text" class="form-control" name="push_template" id="push_template"
                    value="{{ old('push_template', $projectOption->push_template) }}"
                    placeholder="Push notification template">
            </div>

            <button type="submit" class="btn btn-primary">Save Options</button>
        </form>
    </div>
@endsection
