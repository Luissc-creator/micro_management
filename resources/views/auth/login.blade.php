<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestionale Progetti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <h2>Login</h2>
            </div>
            <div class="card-body">
                <form id="loginForm" action='{{ route('auth.login') }}' method='POST'>
                    @csrf
                    <input type="hidden" name="userType" value="{{ $userType }}">

                    @if (session('fail'))
                        <div class='alert alert-danger'>{{ session('fail') }}</div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name='email' required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name='password' required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
