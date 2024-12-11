<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Project Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .dashboard-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .card-body {
            padding: 20px;
        }

        .progress-bar {
            text-align: center;
            color: #fff;
        }

        .badge {
            font-size: 0.9rem;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">🏢 Operator Dashboard</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="freelancer-page.html">📋 Project Management</a>
                <a class="nav-link" href="login.html">🚪 Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Dashboard Cards -->
        <div class="row">
            <!-- Active Projects Card -->
            <div class="col-md-4">
                <div class="card dashboard-card mb-4"
                    onclick="window.location.href='{{ $activeProjects->count() > 0 ? route('operator.area', 0) : '#' }}'">
                    <div class="card-body text-center">
                        <h3 class="card-title">🚀 Active Projects</h3>
                        <div class="display-4 text-primary">{{ $activeProjects->count() }}</div>
                        <p class="text-muted">Projects under development</p>
                    </div>
                </div>
            </div>
            <!-- Open Tasks Card -->
            <div class="col-md-4">
                <div class="card dashboard-card mb-4"
                    onclick="window.location.href='{{ $taskCount > 0 ? route('operator.area', 0) : '#' }}'">
                    <div class="card-body text-center">
                        <h3 class="card-title">📋 Open Tasks</h3>
                        <div class="display-4 text-warning">{{ $taskCount }}</div>
                        <p class="text-muted">Tasks in progress</p>
                    </div>
                </div>
            </div>

            <!-- Communications Card -->
            <div class="col-md-4">
                <div class="card dashboard-card mb-4"
                    onclick="window.location.href='{{ $communicationCount > 0 ? route('communications.list', session('userId')) : '#' }}'">
                    <div class="card-body text-center">
                        <h3 class="card-title">👥 Communications</h3>
                        <div class="display-4 text-success">{{ $communicationCount }}</div>
                        <p class="text-muted">Unread communications</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Status and Deadlines -->
        <div class="row">
            <!-- Project Status -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>📊 Project Status</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($activeProjects as $project)
                            <div class="progress mb-3" style="height: 15px; border-radius: 10px;">
                                <div class="progress-bar {{ $project->progress > 80 ? 'bg-success' : ($project->progress > 40 ? 'bg-warning' : 'bg-info') }}"
                                    role="progressbar"
                                    style="width: {{ $project->progress }}%; color:black; line-height: 15px; border-radius: 10px;"
                                    aria-valuenow="{{ $project->progress }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $project->progress }}%
                                </div>
                            </div>
                            <p class="font-weight-bold mb-2" style="font-size: 14px;">{{ $project->title }}
                                ({{ $project->progress }}%)
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Upcoming Deadlines -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>⏰ Upcoming Deadlines</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($activeProjects as $project)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $project->title }}
                                    <span
                                        class="badge {{ $project->deadline_in_days <= 7
                                            ? 'bg-danger'
                                            : ($project->deadline_in_days <= 15
                                                ? 'bg-warning'
                                                : 'bg-success') }}">
                                        In {{ $project->deadline_in_days }} days
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-4 bg-light py-3">
        <div class="container text-center">
            <p>© 2023 Culture Digitali SRL - Project Management</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
