<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Project Management')</title>
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
    </style>
    @stack('styles') <!-- Additional styles -->
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary position-sticky sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href={{ route('operator.area', 0) }}>🛠️ Operator Area</a>
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
                        <a class="nav-link" href="#" data-bs-toggle="modal"
                            data-bs-target="#projectBriefingModal">
                            📋 Briefing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  open-work-diary" href="#" data-bs-toggle="modal"
                            data-bs-target="#workDiaryModal">
                            📜 Operation Log
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#dailyReportModal">
                            📜 Daily Report
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#taskImportModal">
                            <i class="fas fa-download"></i> Import Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tasks.export') }}" class="nav-link">
                            <i class="fas fa-upload"></i> Export Tasks to XLS
                        </a>
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

    <!-- Main Content -->
    <div class="mt-4">
        @yield('content') <!-- Main content section -->
    </div>

    <!-- Footer -->
    <footer class="footer mt-4 bg-light py-3">
        <div class="text-center">
            <p>© 2023 Culture Digitali SRL - Project Management</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- @stack('scripts') <!-- Additional scripts --> --}}
</body>

</html>
