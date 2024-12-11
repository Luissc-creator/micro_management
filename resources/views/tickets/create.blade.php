@extends('client.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Create a Support Ticket</h1>

        <!-- Error Alerts -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Ticket Form -->
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Title Field -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Ticket Title</label>
                        <input type="text" id="title" name="title" class="form-control"
                            placeholder="Enter ticket title" value="{{ old('title') }}" required>
                    </div>

                    <!-- Description Field -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="5"
                            placeholder="Describe your issue or request in detail" required>{{ old('description') }}</textarea>
                    </div>

                    <!-- File Attachments -->
                    <div class="mb-3">
                        <label for="attachments" class="form-label">Attach Files (optional)</label>
                        <input type="file" id="attachments" name="attachments[]" class="form-control" multiple>
                        <small class="form-text text-muted">You can upload multiple files.</small>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
