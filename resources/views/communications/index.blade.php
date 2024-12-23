@php
    $layout = 'admin.layout'; // Default layout
    if (session('role') == 'operator') {
        $layout = 'operator.layout';
    } elseif (session('role') == 'client') {
        $layout = 'client.layout';
    }
@endphp

@extends($layout)

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Messages</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Message Form Card -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0 text-black"><i class="bi bi-envelope-fill me-2"></i> Send a Message</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('communications.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="receiver_id" class="form-label">Recipient</label>
                                <select id="receiver_id" name="receiver_id" class="form-select" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea id="message" name="message" class="form-control" rows="4" placeholder="Type your message here..."
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachment (optional)</label>
                                <input type="file" id="attachment" name="attachment" class="form-control">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn  bg-warning btn-lg"><i class="bi bi-send me-2"></i>
                                    Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Messages Card -->
            <div class="col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header  bg-warning text-white">
                        <h5 class="mb-0 text-black"><i class="bi bi-chat-dots-fill me-2"></i> Recent Messages
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($communications->isEmpty())
                            <p class="text-center text-muted"><i class="bi bi-inbox me-2"></i> No messages to display.</p>
                        @else
                            <div class="list-group">
                                @foreach ($communications as $communication)
                                    <div class="list-group-item list-group-item-action mb-3 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="fw-bold mb-1">
                                                    <i class="bi bi-person-circle me-2"></i> From:
                                                    {{ $communication->sender->name }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar-event me-1"></i>
                                                    {{ $communication->created_at->format('d M Y, h:i A') }}
                                                </small>
                                            </div>
                                            <span class="badge bg-primary">To: {{ $communication->receiver->name }}</span>
                                        </div>
                                        <p class="mt-2 mb-2">{{ $communication->message }}</p>
                                        @if ($communication->attachment)
                                            <a href="{{ Storage::url($communication->attachment) }}" target="_blank"
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
