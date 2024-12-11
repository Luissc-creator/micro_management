<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Project Management')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles') <!-- Additional styles -->
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">🛠️ Client Area</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#selectProjectModal">
                        🗂️ Select Project
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#projectBriefingModal">
                        📋 Briefing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" id='open-work-diary'
                        data-bs-target="#logOperationsModal">
                        📜 Operation Log
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" {{-- href="{{ route('daily-reports.index', $activeProjects[$currentProjectIndex]->id) }}">Daily --}} Reports</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href={{ route('logout') }}>🚪 Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<body>

    <div class="mt-4">
        @yield('content') <!-- Main content section -->
    </div>

    <footer class="footer mt-4 bg-light py-3">
        <div class="text-center">
            <p>© 2023 Culture Digitali SRL - Project Management</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- @stack('scripts') <!-- Additional scripts --> --}}
</body>

</html>
