<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin – @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f3f4f6;
            font-family: 'Poppins', sans-serif;
        }
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 10px 20px;
        }
    </style>
</head>
<body>

<header class="topbar d-flex justify-content-between align-items-center">
    <div class="fw-semibold">Admin Area</div>

    <form action="{{ route('admin.logout') }}" method="POST" class="m-0">

        @csrf
        <button class="btn btn-outline-dark btn-sm">Logout</button>
    </form>
</header>

<main class="container py-4">
    @yield('content')
</main>

</body>
</html>
