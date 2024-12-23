@php
    $layout = 'client.layout';
@endphp

@extends($layout)

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4 text-primary">Create a Support Ticket</h1>

        <!-- Error Alerts -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <strong>Please address the following issues:</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Ticket Form Card -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-text-fill me-2"></i> Submit a New Ticket</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Operators Dropdown -->
                            <div class="mb-3">
                                <label for="operators" class="form-label">Assign to Operator</label>
                                <select id="operators" name="operator_id" class="form-select" required>
                                    <option value="" disabled selected>Choose an operator</option>
                                    @foreach ($operators as $operator)
                                        <option value="{{ $operator->id }}">{{ $operator->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ticket Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Ticket Title</label>
                                <input type="text" id="title" name="subject" class="form-control shadow-sm"
                                    placeholder="Enter ticket title" value="{{ old('title') }}" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control shadow-sm" rows="5"
                                    placeholder="Describe your issue or request in detail" required>{{ old('description') }}</textarea>
                            </div>

                            <!-- File Attachments -->
                            <div class="mb-3">
                                <label for="attachments" class="form-label">Attach Files (optional)</label>
                                <input type="file" id="attachments" name="attachments[]" class="form-control shadow-sm"
                                    multiple>
                                <small class="form-text text-muted">You can upload multiple files.</small>
                            </div>

                            <!-- Submit and Cancel Buttons -->
                            <div class="d-flex justify-content-end">

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-1"></i> Submit Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Recent Messages Card -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0"><i class="bi bi-chat-dots-fill me-2"></i> Recent Messages</h5>
                    </div>
                    <div class="card-body">
                        @if ($messages->isEmpty())
                            <p class="text-center text-muted">
                                <i class="bi bi-inbox me-2"></i> No messages to display.
                            </p>
                        @else
                            <div class="list-group">
                                @foreach ($messages as $message)
                                    <div class="list-group-item list-group-item-action mb-3 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fw-bold mb-1">
                                                    <i class="bi bi-person-circle me-2"></i> From:
                                                    you
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar-event me-1"></i>
                                                    {{ $message->created_at->format('d M Y, h:i A') }}
                                                </small>
                                            </div>
                                            <span class="badge bg-primary">To: {{ $message->operator->user->name }}</span>
                                        </div>
                                        <p class="mt-2 mb-2">{{ $message->description }}</p>
                                        @if ($message->attachment)
                                            <a href="{{ Storage::url($message->attachment) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-paperclip me-1"></i> View Attachment
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
