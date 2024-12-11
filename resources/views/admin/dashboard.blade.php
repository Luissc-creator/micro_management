@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- User Management Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>User Management</h3>
                    </div>
                    <div class="card-body">
                        <!-- Add User Button -->
                        <button class="btn btn-primary mb-2 w-100" data-bs-toggle="modal" data-bs-target="#addUserModal">Add
                            User</button>

                        <!-- Modal for Adding User -->
                        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.addUser') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="role" class="form-label">Role</label>
                                                <select class="form-select" id="role" name="role" required>
                                                    <option value="admin">Admin</option>
                                                    <option value="operator">Operator</option>
                                                    <option value="client">Client</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Save User</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User List Button -->
                        <a href="{{ route('admin.userList') }}" class="btn btn-secondary mb-2 w-100">User List</a>
                    </div>
                </div>
            </div>

            <!-- Project Management Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Project Management</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('projects.create') }}" class="btn btn-primary w-100 mb-2">New Project</a>
                        <a href="{{ route('projects.active') }}" class="btn btn-secondary w-100 mb-2">Active Projects</a>
                        <a href="{{ route('projects.archivePage') }}" class="btn btn-warning w-100">Archive Projects</a>
                    </div>
                </div>
            </div>

            <!-- Reporting Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Reporting</h3>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-primary mb-2 w-100" href='{{ route('admin.projectReports') }}'>Project Reports</a>
                        <a class="btn btn-secondary mb-2 w-100" href='{{ route('admin.useraReports') }}'>User Reports</a>
                        <a href="{{ route('projects.export') }}" class="btn btn-warning w-100">Export Projects to XLS</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notification Management Section -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Notification Management</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.notification-settings') }}" class="btn btn-primary w-100">
                            <i class="fas fa-bell"></i> Notification Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Section -->
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Recent Activities</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activityLogs as $activityLog)
                                    <tr>
                                        <td>{{ $activityLog->user->name }}</td>
                                        <td>{{ $activityLog->action }}</td>
                                        <td>{{ $activityLog->updated_at }}</td>
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
