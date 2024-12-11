@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container">
        <h1>Projects</h1>
        <a href="/projects/create" class="btn btn-primary mb-3">Create New Project</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Deadline</th>
                    <th>Priority</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->client->user->name }}</td>
                        <td>{{ $project->deadline }}</td>
                        <td>{{ ucfirst($project->priority) }}</td>
                        <td>
                            <a href="/projects/{{ $project->id }}/edit" class="btn btn-warning">Edit</a>
                            <form action="/projects/{{ $project->id }}/delete" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
