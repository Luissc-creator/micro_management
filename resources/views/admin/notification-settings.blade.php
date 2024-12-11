@extends('admin.layout')

@section('content')
    <div class="container">
        <h1>Notification Settings</h1>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createNotificationModal">
            Create New Notification
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Event Type</th>
                    <th>Status</th>
                    <th>Email Recipients</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notification_settings as $notification_setting)
                    <tr>
                        <td>{{ $notification_setting->project->title }}</td>
                        <td>{{ $notification_setting->event_type }}</td>
                        <td>
                            <input type="checkbox" {{ $notification_setting->status ? 'checked' : '' }} disabled>
                        </td>
                        <td>{{ $notification_setting->email_recipients }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm edit-notification"
                                data-id="{{ $notification_setting->id }}" data-bs-toggle="modal"
                                data-bs-target="#editNotificationModal-{{ $notification_setting->id }}">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Create Notification Modal -->
        <div class="modal fade" id="createNotificationModal" tabindex="-1" aria-labelledby="createNotificationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createNotificationModalLabel">Create Notification</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="notificationForm" method="POST"
                            action="{{ route('admin.notification-settings.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="projects" class="form-label">Projects</label>
                                <select class="form-select" id="projects" name="project_id">
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="event_type" class="form-label">Event Type</label>
                                <input type="text" class="form-control" id="event_type" name="event_type" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="email_recipients" class="form-label">Email Recipients</label>
                                <input type="email" class="form-control" id="email_recipients" name="email_recipients"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="frequency" class="form-label">Frequency</label>
                                <select class="form-select" id="frequency" name="frequency">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="custom_subject" class="form-label">Custom Subject</label>
                                <input type="text" class="form-control" id="custom_subject" name="custom_subject"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="custom_message" class="form-label">Custom Message</label>
                                <textarea class="form-control" id="custom_message" name="custom_message" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @foreach ($notification_settings as $notification_setting)
            <!-- Edit Notification Modal -->
            <div class="modal fade" id="editNotificationModal-{{ $notification_setting->id }}" tabindex="-1"
                aria-labelledby="editNotificationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editNotificationModalLabel">Edit Notification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editNotificationForm" method="POST"
                                action="{{ route('admin.notification-settings.update') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $notification_setting->id }}">
                                <div class="mb-3">
                                    <label for="projects" class="form-label">Projects</label>
                                    <select class="form-select" id="projects" name="project_id">
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ $notification_setting->project->id == $project->id ? 'selected' : '' }}>
                                                {{ $project->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="event_type" class="form-label">Event Type</label>
                                    <input type="text" class="form-control" id="event_type" name="event_type"
                                        value="{{ $notification_setting->event_type }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="1" {{ $notification_setting->status == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ $notification_setting->status == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="email_recipients" class="form-label">Email Recipients</label>
                                    <textarea class="form-control" id="email_recipients" name="email_recipients" rows="3"
                                        placeholder="Enter each email address on a new line">{{ $notification_setting->email_recipients }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="frequency" class="form-label">Frequency</label>
                                    <select class="form-select" id="frequency" name="frequency">
                                        <option value="daily"
                                            {{ $notification_setting->frequency == 'daily' ? 'selected' : '' }}>Daily
                                        </option>
                                        <option value="weekly"
                                            {{ $notification_setting->frequency == 'weekly' ? 'selected' : '' }}>Weekly
                                        </option>
                                        <option value="custom"
                                            {{ $notification_setting->frequency == 'custom' ? 'selected' : '' }}>Custom
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="custom_subject" class="form-label">Custom Subject</label>
                                    <input type="text" class="form-control" id="custom_subject" name="custom_subject"
                                        value="{{ $notification_setting->custom_subject }}">
                                </div>
                                <div class="mb-3">
                                    <label for="custom_message" class="form-label">Custom Message</label>
                                    <textarea class="form-control" id="custom_message" name="custom_message" rows="3">{{ $notification_setting->custom_message }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
