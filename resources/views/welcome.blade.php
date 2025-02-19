<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: none;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #FF2D20;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #d9261b;
        }
    </style>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="card text-center">
            <h1 class="mb-4">Selamat Datang di Manajemen Keuangan</h1>
            <p class="lead">Kelola keuangan Anda dengan lebih mudah dan efisien.</p>
            <div class="mt-4">
                @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-custom">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-custom me-2">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
                @endif
                @endauth
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>