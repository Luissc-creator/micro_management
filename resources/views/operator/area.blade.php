@extends('operator.layout')
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
    @if ($operator->missed_daily_report)
        <div class="alert alert-warning">
            😢 You missed submitting your daily report yesterday.
        </div>
    @endif
    <!-- Main Content -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-8">
                <!-- Project Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mr-3">📊 Project Details</h4>
                        <h2 class='m-auto text-warning'>{{ $activeProjects[$currentProjectIndex]->title }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-center mb-3 bg-light">
                                    <div class="card-header">⏱️ Hours Worked</div>
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
                                        <div class="card-header">📈 Progress</div>
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
                                <div class="card text-center mb-3 bg-light">
                                    <div class="card-header">🕒 Project Deadline</div>
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
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>📋 Ongoing Tasks</h3>
                        <div>
                            <button class="btn btn-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                                + New Task
                            </button>
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr id="task-row-{{ $task->id }}">
                                        <td>{{ $task->task_name }}</td>
                                        <td>{{ $task->task_description }}</td>
                                        <td>
                                            @switch($task->task_priority)
                                                @case('high')
                                                    <span class="badge bg-danger">🔴</span>
                                                @break

                                                @case('medium')
                                                    <span class="badge bg-warning">🟡</span>
                                                @break

                                                @case('low')
                                                    <span class="badge bg-success">🟢</span>
                                                @break
                                            @endswitch
                                            {{ $task->task_priority }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge 
            @if ($task->status === 'in_progress') bg-primary @elseif($task->status === 'completed') bg-info 
            @elseif($task->status === 'cancelled' || $task->status === 'overdue') bg-danger @else bg-warning text-secondary @endif">
                                                {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ $task->task_deadline }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-success complete-btn"
                                                    data-id="{{ $task->id }}">✅</button>
                                                <button class="btn btn-warning pause-btn"
                                                    data-id="{{ $task->id }}">⏸️</button>
                                                <button class="btn btn-warning start-btn"
                                                    data-id="{{ $task->id }}">▶️</button>
                                                <button class="btn btn-danger cancel-btn" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-id="{{ $task->id }}">❌</button>
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
                <div class="card mb-4 border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h3>⚠️ Urgent Notices</h3>
                    </div>
                    <div class="card-body">
                        {{-- @if (!$hasReport)
                            <div class="alert alert-warning">
                                😞 You missed today's daily update.
                            </div>
                        @endif --}}

                        <div class="alert alert-warning d-flex align-items-center">
                            <span class="emoji-badge">🔔</span>
                            <div>
                                <strong>Pending Client Request:</strong> Requires a response within 48 hours.
                            </div>
                        </div>
                        <div class="alert alert-info d-flex align-items-center">
                            <span class="emoji-badge">📬</span>
                            <div>
                                <strong>New Communication:</strong> Clarification request from the client.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Client Communications -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>💬 Client Communications</h3>
                        <a class="btn btn-light btn-sm" href={{ route('communications.index') }}>
                            + New
                        </a>
                        {{-- data-bs-toggle="modal"
                        data-bs-target="#newCommunicationModal" --}}
                    </div>
                    <div class="card-body">
                        <div class="list-group" id="clientCommunicationsList">
                            <div href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">❓ Feature Clarification</h5>
                                    <small>🔵 Pending</small>
                                </div>
                                <p class="mb-1">Additional details about the reporting module</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Requests to Client -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>🔍 Requests to Client</h3>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal"
                            data-bs-target="#newRequestClientModal">
                            + New
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="list-group" id="clientRequestsList">

                        </div>
                    </div>
                </div>
                <!--New Request Modal -->
                <div class="modal fade" id="newRequestClientModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">📝 New Request</h5>
                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="requestForm" method="POST">
                                    @csrf
                                    <input type='hidden' name='client_id'
                                        value={{ $activeProjects[$currentProjectIndex]->client_id }}>
                                    <div class="mb-3">
                                        <label for="task_id" class="form-label">Task Title</label>
                                        <select class="form-select" id="task_id" name="task_id" required>
                                            @foreach ($activeProjects[$currentProjectIndex]->tasks as $task)
                                                <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for='task-type'>🏷️ Request Type</label>
                                        <input type="text" class="form-control" id='task-type' name='type'
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for='message'>📄 Details</label>
                                        <textarea class="form-control" id='message' name='message' rows="4" required></textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Submit Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Client Tickets -->
                <div class="card">
                    <div class="card-header">
                        <h3>🎫 Client Tickets</h3>
                    </div>
                    <div class="card-body">
                        <div class="list-group" id="clientTicketsList">
                            <a href={{ route('tickets.index') }} class="list-group-item list-group-item-action">
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
                                    href="{{ url('operator/' . $loop->index . '/area') }}">{{ $project->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- New Task Modal -->
    <div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="newTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newTaskModalLabel">Create a New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- New Task Creation Form -->
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <input type='hidden' value={{ $activeProjects[$currentProjectIndex]->id }} name='project_id'>
                        <div class="mb-3">
                            <label for="task_name" class="form-label">Task Name</label>
                            <input type="text" class="form-control" id="task_name" name="task_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="task_description" class="form-label">Task Description</label>
                            <textarea class="form-control" id="task_description" name="task_description" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="task_priority" class="form-label">Priority</label>
                            <select class="form-control" id="task_priority" name="task_priority" required>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="task_deadline" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="task_deadline" name="task_deadline" required>
                        </div>

                        <!-- Submit Button to Create Task -->
                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </form>
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
    <!-- Daily Report Modal -->
    <div class="modal fade" id="dailyReportModal" tabindex="-1" aria-labelledby="dailyReportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dailyReportModalLabel">Submit Daily Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for submitting daily report -->
                    <form id="dailyReportForm" action="{{ route('operator.daily-report') }}" method="POST">
                        @csrf
                        <input type='hidden' name='project_id' value='{{ $activeProjects[$currentProjectIndex]->id }}'>
                        <div class="mb-3">
                            <label for="report_content" class="form-label">Daily Update</label>
                            <textarea name="report_content" id="report_content" class="form-control" rows="5"
                                placeholder="Write your daily update..." required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Work Diary Modal -->
    <div class="modal fade" id="workDiaryModal" tabindex="-1" aria-labelledby="workDiaryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workDiaryModalLabel">Work Diary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Content for Activity Logs and Daily Updates -->
                    <div id="workDiaryContent">
                        <!-- Activity Log (All logs for the project) -->
                        <ul id="activityLogList" class="list-group mb-4">
                            <!-- Dynamically load activity logs here -->
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Task Import Modal -->
    <div class="modal fade" id="taskImportModal" tabindex="-1" aria-labelledby="taskImportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskImportModalLabel">Import Tasks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskImportForm" action="{{ route('tasks.import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Task File</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                            <small class="form-text text-muted">
                                Supported formats: .xlsx, .csv, .txt
                            </small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="taskImportForm" class="btn btn-primary">Import</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this task? Please enter your password to confirm.</p>
                    <input type="hidden" id="deleteTaskId" value="">
                    <div class="mb-3">
                        <label for="deletePassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="deletePassword"
                            placeholder="Enter your password">
                    </div>
                    <div class="alert alert-danger d-none" id="passwordError"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Yes</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Triggering the modal
        $(document).on('click', '.open-work-diary', function() {
            const projectId = $(this).data('project-id'); // Get the project ID from the button's data attribute

            // Make AJAX request to fetch work diary data
            $.ajax({
                url: `/work-diary/${projectId}`,
                method: 'GET',
                success: function(data) {
                    // Clear previous content
                    $('#activityLogList').empty();
                    $('#dailyUpdatesList').empty();

                    // Populate the activity logs
                    data.activityLogs.forEach(function(log) {
                        $('#activityLogList').append(`
                    <li class="list-group-item">
                        ${log.action} - ${log.created_at}
                    </li>
                `);
                    });

                    // Populate the daily updates
                    data.dailyUpdates.forEach(function(update) {
                        const updateStatus = update.status === 'sent' ? 'text-success' :
                            'text-danger';
                        $('#dailyUpdatesList').append(`
                    <li class="list-group-item ${updateStatus}">
                        ${update.update_text} - ${update.created_at}
                    </li>
                `);
                    });

                    // Show the modal
                    $('#workDiaryModal').modal('show');
                },
                error: function(err) {
                    console.error('Error fetching work diary data:', err);
                    alert('There was an error loading the work diary data.');
                }
            });
        });
        $('.complete-btn').click(function() {
            const taskId = $(this).data('id');
            $.post(`/tasks/${taskId}/under_review`, {
                _token: '{{ csrf_token() }}'
            }, function(response) {
                alert(response.message);
                location.reload(); // Reload page to reflect changes
            });
        });

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

            $("#requestForm").on("submit", function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('requests.store') }}", // Your route to store the request
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message); // Display success message
                            $('#newRequestClientModal').modal('hide'); // Hide the modal
                        } else {
                            alert("Something went wrong!");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert("An error occurred.");
                    }
                });
                requests_show_all();
            });
        });
        $(document).ready(function() {
            // Handle Delete Modal Trigger
            $('.cancel-btn').click(function() {
                const taskId = $(this).data('id');
                $('#deleteTaskId').val(taskId); // Set Task ID in Modal
                $('#passwordError').addClass('d-none'); // Hide error
            });

            // Confirm Delete
            $('#confirmDelete').click(function() {
                const taskId = $('#deleteTaskId').val();
                const password = $('#deletePassword').val();

                $.ajax({
                    url: `/tasks/${taskId}/cancel`, // Your delete route
                    type: 'POST',
                    data: {
                        password: password,
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Task deleted successfully!');
                            $(`#task-row-${taskId}`).remove(); // Remove row from table
                            $('#deleteModal').modal('hide');
                            $('.modal-backdrop').remove(); // Remove the backdrop
                        } else {
                            $('#passwordError').text(response.message).removeClass('d-none');
                        }
                    },
                    error: function(xhr) {
                        $('#passwordError').text('An error occurred. Please try again.')
                            .removeClass('d-none');
                    }
                });
            });

            // Handle Complete Task
            $('.complete-btn').click(function() {
                const taskId = $(this).data('id');
                updateTaskStatus(taskId, 'completed');
            });

            // Handle Pause Task
            $('.pause-btn').click(function() {
                const taskId = $(this).data('id');
                updateTaskStatus(taskId, 'paused');
            });

            // Handle Start Task
            $('.start-btn').click(function() {
                const taskId = $(this).data('id');
                updateTaskStatus(taskId, 'in_progress');
            });

            // Reusable Function for Status Updates
            function updateTaskStatus(taskId, status) {
                $.ajax({
                    url: `/tasks/${taskId}/status`, // Your status update route
                    type: 'POST',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Task status updated!');
                            location.reload(); // Reload the page or dynamically update the status badge
                        }
                    },
                    error: function(xhr) {
                        alert('Failed to update task status.');
                    }
                });
            }
        });


        function requests_show_all() {
            $.ajax({
                url: "{{ route('requests.show_all') }}", // Your route to store the request
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        $('#newRequestClientModal').modal('hide'); // Hide the modal
                        // You can also update the UI without reloading
                        const type = ['🟡 In Progress']
                        $('#clientRequestsList').empty();
                        response.data.forEach(function(request) {
                            $('#clientRequestsList').append(
                                `<a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">🖥️ ${request.type}</h5>
                                            <small>🟡 In Progress</small>
                                        </div>
                                        <p class="mb-1">${request.message}</p>
                                    </a>`
                            );
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log("XHR object:", xhr);
                    console.log("Status:", status);
                    console.log("Error:", error);
                    alert("An error occurred: " + error);
                }
            });
        }
        requests_show_all();
    </script>
@endsection
