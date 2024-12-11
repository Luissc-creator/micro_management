@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <script>
        function confirmDelete(url) {
            if (!confirm('Are you sure you want to delete this user?')) {
                return false; // Prevent default action (form submission)
            }
        }
    </script>
    <div class="container mt-4">
        <h2 class="mb-4">User List</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editRoleModal{{ $user->id }}">Edit</button>
                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirmDelete()"
                                    class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="editRoleModal{{ $user->id }}" tabindex="-1"
                        aria-labelledby="editRoleModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editRoleModalLabel{{ $user->id }}">Edit Role for
                                        {{ $user->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name', $user->name) }}" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ old('email', $user->email) }}" required>
                                        </div>

                                        <!-- Role Select Dropdown -->
                                        <div class="form-group">
                                            <label for="role">Select Role</label>
                                            <select name="role" class="form-control" required>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                </option>
                                                <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>
                                                    Operator
                                                </option>
                                                <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>
                                                    Client</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update Role</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Optionally, add pagination -->
        {{-- <!-- {{ $users->links() }} --> --}}
    </div>
@endsection
