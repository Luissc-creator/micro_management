@extends('admin.layout')

@section('title', 'User Reports')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>User Reports</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Last Login</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                        <!-- Updated Index -->
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>{{ $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i') : 'Never' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.editUser', $user->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination Section -->
                        <div class="mt-3">
                            <nav aria-label="User Pagination">
                                <ul class="pagination justify-content-center">
                                    <!-- Previous Page Button -->
                                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}"
                                            tabindex="-1">Previous</a>
                                    </li>

                                    <!-- Page Numbers -->
                                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                                        <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    <!-- Next Page Button -->
                                    <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
