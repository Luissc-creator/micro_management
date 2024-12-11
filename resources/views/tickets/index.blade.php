@if (session('role' == 'operator'))
    @extends('operator.layout')
@endif
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Support Tickets</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('role' == 'client'))
            <!-- Create Ticket Button -->
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('tickets.create') }}" class="btn btn-primary">+ Create New Ticket</a>
            </div>
        @endif


        <!-- Tickets List -->
        @if ($tickets->count() > 0)
            <div class="row">
                @foreach ($tickets as $ticket)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $ticket->title }}</h5>
                                <p class="card-text text-truncate" style="max-height: 3.5em; overflow: hidden;">
                                    {{ $ticket->description }}</p>
                                <div class="mb-2">
                                    <span
                                        class="badge bg-{{ $ticket->status == 'open' ? 'success' : ($ticket->status == 'in_progress' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </div>
                                <a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">
                No tickets found.
            </div>
        @endif
    </div>
@endsection
