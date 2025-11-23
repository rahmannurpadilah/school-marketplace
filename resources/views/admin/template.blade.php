<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #fff;
            color: #343a40;
        }

        .sidebar .nav-link.active {
            background-color: #ffffff;
            color: #000000;
        }

        .sidebar-header {
            text-align: center;
            font-size: 1.4rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 1rem;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
            padding-top: 70px;
        }

        .navbar-top {
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            background: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            z-index: 1000;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fa-solid fa-user-shield"></i> Admin Panel
        </div>
        <a href="{{route('admin.dashboard')}}" class="nav-link {{request()->routeIs('admin.dashboard') ? 'active' : ''}}"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="{{ route('admin.useradmin') }} " class="nav-link {{request()->routeIs('admin.useradmin') ? 'active' : ''}}"><i class="fa-solid fa-users"></i> Users</a>
        <a href="{{route('admin.produk')}}"  class="nav-link {{request()->routeIs('admin.produk') ? 'active' : ''}}"><i class="fa-solid fa-box"></i> Products</a>
        <a href="{{route('admin.toko.index')}}" class="nav-link {{request()->routeIs('admin.toko.index') ? 'active' : ''}}"><i class="fa-solid fa-chart-line"></i> toko</a>
        <a href="{{route('admin.kategori')}}" class="nav-link {{request()->routeIs('admin.kategori') ? 'active' : ''}}"><i class="fa-solid fa-gear"></i> kategori</a>
        <a href="{{route('logout')}}" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <!-- Tempat Konten Utama -->
    <div class="main-content">

        <div class="navbar-top">
            <h4>@yield('title')</h4>
            <div>
                <i class="fa-solid fa-bell"></i>
                <i class="fa-solid fa-user ms-3"></i>
            </div>
        </div>

        <div class="container mt-4">
            @yield('content')
        </div>

    </div>

</body>
</html>
