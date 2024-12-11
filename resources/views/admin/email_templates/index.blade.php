@extends('admin.layout')

@section('content')
    <h1>Email Templates</h1>
    <a href="{{ route('admin.email_templates.showCreateForm') }}" class="btn btn-primary">Create New Template</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Subject</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($templates as $template)
                <tr>
                    <td>{{ $template->name }}</td>
                    <td>{{ $template->subject }}</td>
                    <td>
                        <a href="{{ route('admin.email_templates.edit', $template->id) }}" class="btn btn-warning">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
