<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles and Permissions - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard Administrator</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="login.html">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Roles</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($roles as $role)
                                <li class="list-group-item">
                                    {{ $role->name }}
                                    <button class="btn btn-warning btn-sm float-end">Edit</button>
                                </li>
                            @endforeach
                        </ul>
                        <button class="btn btn-primary mt-2 w-100">Add Role</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Permissions</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($permissions as $permission)
                                <li class="list-group-item">
                                    {{ $permission->name }}
                                    <button class="btn btn-warning btn-sm float-end">Edit</button>
                                </li>
                            @endforeach
                        </ul>
                        <button class="btn btn-primary mt-2 w-100">Add Permission</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
