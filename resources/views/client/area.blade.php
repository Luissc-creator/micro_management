@extends('client.layout')
@section('content')
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .emoji-badge {
            font-size: 1.2em;
            margin-right: 10px;
        }
    </style>

    <!-- Navbar -->


    <!-- Main Content -->
    <div class="mt-4 container-fluid">
        <div class="row">
            <div class="col-md-8">


                <!-- Project Details -->
                <div class="mb-4 card">
                    <div class="card-header bg-success">
                        <h4 class="mr-3">📊 Project Details</h4>
                        <h2 class='m-auto text-warning'>{{ $activeProjects[$currentProjectIndex]->title }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3 text-center card bg-light">
                                    <div class="card-header bg-success">⏱️ Hours Worked</div>
                                    <div class="card-body">
                                        <h2 class="card-title">
                                            {{ (int) $activeProjects[$currentProjectIndex]->hoursWorked }}
                                            <small class="text-muted">hours</small>
                                        </h2>
                                        <p class="card-text text-muted">Total hours spent</p>
                                    </div>
                                </div>
                            </div>
                            @if ($activeProjects[$currentProjectIndex]->project_status !== 'blocked')
                                <div class="col-md-4">
                                    <div class="card text-center mb-3 bg-light">
                                        <div class="card-header bg-success">📈 Progress</div>
                                        <div class="card-body">
                                            <h2 class="card-title">
                                                {{ $activeProjects[$currentProjectIndex]->progress }}<small
                                                    class="text-muted">%</small></h2>
                                            <div class="progress">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: {{ $activeProjects[$currentProjectIndex]->progress }}%;"
                                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <p class="card-text text-muted mt-2">Overall progress</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-4">
                                    <div class="card text-center mb-3 bg-light">
                                        <div class="card-header bg-secondary">📈 Progress</div>
                                        <div class="card-body text-muted">
                                            <h2 class="card-title">
                                                {{ $activeProjects[$currentProjectIndex]->progress }}<small
                                                    class="text-muted">%</small></h2>
                                            <div class="progress ">
                                                <div class="progress-bar bg-primary text-muted" role="progressbar"
                                                    style="width: {{ $activeProjects[$currentProjectIndex]->progress }}%;"
                                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <p class="card-text text-muted mt-2">Overall progress</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <div class="mb-3 text-center card bg-light">
                                    <div class="card-header bg-success">🕒 Project Deadline</div>
                                    <div class="card-body">
                                        <h2 class="card-title">
                                            {{ (int) $activeProjects[$currentProjectIndex]->remainedDays }} <small
                                                class="text-muted">days</small></h2>
                                        <p class="card-text text-muted">Time remaining</p>
                                        <small class="text-muted">Delivery:
                                            {{ $activeProjects[$currentProjectIndex]->deadline }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ongoing Tasks -->
                <div class="mb-4 card">
                    <div class="card-header bg-success">
                        <h3>📋 Ongoing Tasks</h3>
                        <div>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#importBatchTaskModal">
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->task_name }}</td>
                                        <td>{{ $task->task_description }}</td>
                                        <td>
                                            @switch($task->task_priority)
                                                @case('high')
                                                    <span class="badge bg-danger">
                                                        🔴
                                                    @break

                                                    @case('medium')
                                                        <span class="badge bg-warning">
                                                            🟡
                                                        @break

                                                        @case('low')
                                                            <span class="badge bg-success">
                                                                🟢
                                                            @break

                                                            @default
                                                        @endswitch
                                                        {{ $task->task_priority }}
                                                    </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                @if ($task->status === 'in_progress')
                                                    ⏳ In Progress
                                                @elseif($task->status === 'completed')
                                                    ✅ Completed
                                                @elseif($task->status === 'pending_client')
                                                    ⏸ Paused
                                                @else
                                                    ❌ Canceled
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $task->task_deadline }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-success complete-btn"
                                                    data-id="{{ $task->id }}">✅</button>
                                                <button class="btn btn-warning pause-btn"
                                                    data-id="{{ $task->id }}">⏸️</button>
                                                <button class="btn btn-danger cancel-btn"
                                                    data-id="{{ $task->id }}">❌</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">

                <!-- Urgent Notices -->
                <div class="mb-4 card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h3>⚠️ Urgent Notices</h3>
                    </div>
                    <div class="card-body">

                        @foreach ($requests as $request)
                            <div
                                class="p-4 mb-3 shadow-sm list-group-item d-flex justify-content-between align-items-center bg-warning">
                                <div>
                                    <p class="mb-1">Request from
                                    <h3>{{ $request->client->name }}</h3>
                                    </p>
                                    <p class="mb-1">{{ $request->message }}</p>
                                    <small class="text-muted">Created on: {{ $request->created_at }}</small>
                                </div>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    onclick={{ $currentRequestId = $request->id }} data-bs-target="#responseModal"
                                    data-request-id="{{ $request->id }}" data-request-message="{{ $request->message }}">
                                    Respond
                                </button>
                            </div>
                            <!-- Response Modal -->
                            <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="responseModalLabel">Respond to Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Request Message:</strong> <span id="modalRequestMessage"></span>
                                            </p>
                                            <form id="responseForm"
                                                action="{{ route('requests.respond', $request->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" id="modalRequestId" name="request_id">
                                                <div class="mb-3">
                                                    <label for="message" class="form-label">Your Response</label>
                                                    <textarea class="shadow-sm form-control" id="message" name="message" rows="4"
                                                        placeholder="Write your response here..."></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="file" class="form-label">Attach File
                                                        (optional)
                                                    </label>
                                                    <input class="shadow-sm form-control" type="file" id="file"
                                                        name="file">
                                                </div>

                                                <button type="submit" class="btn btn-primary">Submit
                                                    Response</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- <div class="alert alert-info d-flex align-items-center">
                            <span class="emoji-badge">📬</span>
                            <div>
                                <strong>New Communication:</strong> Clarification request from the client.
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Client Communications -->
                <div class="mb-4 card">
                    <div class="card-header bg-success">
                        <h3>💬 Client Communications</h3>
                        <a class="btn btn-light btn-sm" href={{ route('communications.index') }}>
                            + New
                        </a>
                        {{-- data-bs-toggle="modal" data-bs-target="#newCommunicationModal" --}}
                    </div>
                    <div class="card-body">
                        <div class="list-group" id="clientCommunicationsList">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">❓ Feature Clarification</h5>
                                    <small>🔵 Pending</small>
                                </div>
                                <p class="mb-1">Additional details about the reporting module</p>
                            </a>
                        </div>
                    </div>
                </div>


                <!-- Client Tickets -->
                <div class="card">
                    <div class="card-header bg-success">
                        <h3>🎫 Client Tickets</h3>
                    </div>
                    <div class="card-body">
                        <div class="list-group" id="clientTicketsList">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">🔴 System Error</h5>
                                    <small class="text-muted">Closed</small>
                                </div>
                                <p class="mb-1">Error during client login</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Selecting Project -->
    <div class="modal fade" id="selectProjectModal" tabindex="-1" aria-labelledby="selectProjectModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectProjectModalLabel">🗂️ Select Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @foreach ($activeProjects as $project)
                            <li class="list-group-item">
                                <a class="btn w-100"
                                    href="{{ url('client/' . $loop->index . '/area') }}">{{ $project->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Briefing Modal -->
    <div class="modal fade" id="projectBriefingModal" tabindex="-1" aria-labelledby="projectBriefingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectBriefingModalLabel">Project Briefing for
                        ''{{ $activeProjects[$currentProjectIndex]->title }}''
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Load briefing content via AJAX here -->
                    <div id="projectBriefingContent">
                        Loading...
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.js"></script>

    <script>
        const echo = new window.Echo({
            broadcaster: 'pusher',
            key: '050e38dcbcd82e7ec970',
            cluster: 'us2', // Example: 'mt1'
            forceTLS: true,
        });
        // 
        echo.channel('project.{{ $activeProjects[$currentProjectIndex]->id }}')
            .listen('OperatorRequestSent', (data) => {
                console.log('New event received:', data);

                // You can add your logic to handle the data
                alert('new message ' + data);
            });
    </script>
    <script>
        $(document).ready(function() {
            // Trigger modal opening and load content via AJAX
            $('#projectBriefingModal').on('show.bs.modal', function(event) {
                var projectId =
                    {{ $activeProjects[$currentProjectIndex]->id }}; // Assuming you have the project ID
                var modal = $(this);

                // Load the project briefing via AJAX
                $.ajax({
                    url: '/projects/' + projectId +
                        '/briefing', // API endpoint to fetch the briefing
                    method: 'GET',
                    success: function(response) {
                        // Inject the briefing content into the modal
                        $('#projectBriefingContent').html(response);
                    },
                    error: function() {
                        $('#projectBriefingContent').html(
                            '<p>Error loading project briefing.</p>');
                    }
                });
            });

            // Handle Complete Task
            $('.complete-btn').click(function() {
                const taskId = $(this).data('id');
                $.post(`/tasks/${taskId}/complete`, {
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    alert(response.message);
                    location.reload(); // Reload page to reflect changes
                });
            });

            // Handle Pause Task
            $('.pause-btn').click(function() {
                const taskId = $(this).data('id');
                $.post(`/tasks/${taskId}/pause`, {
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    alert(response.message);
                    location.reload();
                });
            });

            // Handle Cancel Task
            $('.cancel-btn').click(function() {
                const taskId = $(this).data('id');
                $.post(`/tasks/${taskId}/cancel`, {
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    alert(response.message);
                    location.reload();
                });
            });
        });
    </script>
@endsection
