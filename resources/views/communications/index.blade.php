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
    <div class="container">
        <h1 class="mb-4">Messages</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Message Form -->
        <form action="{{ route('communications.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="receiver_id" class="form-label">Recipient</label>
                <select id="receiver_id" name="receiver_id" class="form-control" value='1' required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Attachment (optional)</label>
                <input type="file" id="attachment" name="attachment" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>

        <!-- Messages -->
        <div class="list-group">
            @foreach ($communications as $communication)
                <div class="list-group-item">
                    <p><strong>From:</strong> {{ $communication->sender->name }}</p>
                    <p><strong>To:</strong> {{ $communication->receiver->name }}</p>
                    <p>{{ $communication->message }}</p>
                    @if ($communication->attachment)
                        <p><a href="{{ Storage::url($communication->attachment) }}" target="_blank">View Attachment</a></p>
                    @endif
                    <small class="text-muted">{{ $communication->created_at->format('d M Y, h:i A') }}</small>
                </div>
            @endforeach
        </div>
    </div>
@endsection
