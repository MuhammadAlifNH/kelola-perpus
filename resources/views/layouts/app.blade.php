<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Kelola Perpus</a>
            <div class="d-flex ms-auto">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('books.index') }}" class="btn btn-outline-primary me-2">Admin Panel</a>
                        <a href="{{ route('admin.borrows') }}" class="btn btn-outline-info me-2">Kelola Peminjaman</a>
                    @else
                        <a href="{{ route('user.borrows') }}" class="btn btn-outline-info me-2">Pinjaman Saya</a>
                    @endif
                    <span class="navbar-text me-2">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-success">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
