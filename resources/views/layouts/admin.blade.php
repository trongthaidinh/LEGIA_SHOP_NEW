<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        
        #sidebar {
            min-height: 100vh;
            width: 250px;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
        }
        
        #sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        
        #sidebar .nav-link:hover {
            background: #495057;
        }
        
        #sidebar .nav-link i {
            margin-right: 10px;
        }
        
        .content {
            width: calc(100% - 250px);
        }
        
        .navbar {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .main-content {
            padding: 20px;
        }
        
        .sidebar-header {
            padding: 20px;
            background: #2c3136;
        }
        
        .admin-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link">
                        <i class="fas fa-list"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link">
                        <i class="fas fa-box"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="btn btn-link">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle text-dark" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? 'Admin' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="main-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar
        document.querySelector('.btn-link').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('d-none');
            document.querySelector('.content').classList.toggle('w-100');
        });
    </script>
</body>
</html>
