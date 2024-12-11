@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4 text-center">Project Management Dashboard</h1>

        <div class="card shadow-sm mb-5">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Active Projects</h2>
            </div>
            <div class="card-body">
                @if ($activeProjects->isEmpty())
                    <p class="text-muted text-center">No active projects available.</p>
                @else
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Project Name</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeProjects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td class="text-center">
                                        <!-- Trigger the modal with a button -->
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#archiveModal-{{ $project->id }}">
                                            Archive
                                        </button>

                                        <!-- Archive Confirmation Modal -->
                                        <div class="modal fade" id="archiveModal-{{ $project->id }}" tabindex="-1"
                                            aria-labelledby="archiveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="archiveModalLabel">Confirm Archive</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to archive the project
                                                        <strong>{{ $project->title }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <!-- Add a trigger for form submission here -->
                                                        <button type="button" class="btn btn-warning"
                                                            onclick="document.getElementById('archive-form-{{ $project->id }}').submit();">
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden form to handle the archive action -->
                                        <form id="archive-form-{{ $project->id }}"
                                            action="{{ route('projects.archive', $project->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h2 class="mb-0">Archived Projects</h2>
            </div>
            <div class="card-body">
                @if ($archivedProjects->isEmpty())
                    <p class="text-muted text-center">No archived projects available to unarchive.</p>
                @else
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Project Name</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($archivedProjects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->description }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#unarchiveModal-{{ $project->id }}">
                                            Unarchive
                                        </button>

                                        <!-- Unarchive Confirmation Modal -->
                                        <div class="modal fade" id="unarchiveModal-{{ $project->id }}" tabindex="-1"
                                            aria-labelledby="unarchiveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="unarchiveModalLabel">Confirm Unarchive
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to unarchive the project
                                                        <strong>{{ $project->name }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <!-- Add a trigger for form submission here -->
                                                        <button type="button" class="btn btn-secondary"
                                                            onclick="document.getElementById('unarchive-form-{{ $project->id }}').submit();">
                                                            Confirm
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden form to handle the unarchive action -->
                                        <form id="unarchive-form-{{ $project->id }}"
                                            action="{{ route('projects.unarchive', $project->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
