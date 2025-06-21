<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KFC Restaurant Management')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --kfc-red: #E4002B;
            --kfc-dark-red: #B8001F;
            --kfc-gold: #FFD700;
            --kfc-black: #000000;
        }
        
        body {
            font-family: 'Arial', sans-serif;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            color: var(--kfc-red) !important;
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-nav .nav-link {
            color: var(--kfc-black) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--kfc-red) !important;
        }
        
        .btn-kfc {
            background-color: var(--kfc-red);
            border-color: var(--kfc-red);
            color: white;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 25px;
            transition: all 0.3s;
        }
        
        .btn-kfc:hover {
            background-color: var(--kfc-dark-red);
            border-color: var(--kfc-dark-red);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-outline-kfc {
            border: 2px solid var(--kfc-red);
            color: var(--kfc-red);
            background: transparent;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 25px;
            transition: all 0.3s;
        }
        
        .btn-outline-kfc:hover {
            background-color: var(--kfc-red);
            color: white;
            transform: translateY(-2px);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--kfc-red), var(--kfc-dark-red));
            color: white;
            padding: 100px 0;
        }
        
        .card {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .footer {
            background-color: var(--kfc-black);
            color: white;
            padding: 50px 0 20px;
        }
        
        .sidebar {
            background-color: #f8f9fa;
            min-height: calc(100vh - 76px);
            padding: 20px 0;
        }
        
        .sidebar .nav-link {
            color: var(--kfc-black);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--kfc-red);
            color: white;
        }
        
        .admin-header {
            background: linear-gradient(135deg, var(--kfc-red), var(--kfc-dark-red));
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        
        .stats-card {
            background: linear-gradient(135deg, var(--kfc-red), var(--kfc-dark-red));
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }
        
        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .table th {
            background-color: var(--kfc-red);
            color: white;
            border: none;
            font-weight: 600;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .form-control:focus {
            border-color: var(--kfc-red);
            box-shadow: 0 0 0 0.2rem rgba(228, 0, 43, 0.25);
        }
        
        .menu-item-card {
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s;
        }
        
        .menu-item-card:hover {
            transform: scale(1.05);
        }
        
        .menu-item-card img {
            height: 200px;
            object-fit: cover;
        }
        
        .price-tag {
            background-color: var(--kfc-gold);
            color: var(--kfc-black);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .loading {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        
        .status-pending { background-color: #ffeaa7; color: #2d3436; }
        .status-confirmed { background-color: #74b9ff; color: white; }
        .status-preparing { background-color: #fd79a8; color: white; }
        .status-ready { background-color: #00b894; color: white; }
        .status-delivered { background-color: #00cec9; color: white; }
        .status-cancelled { background-color: #636e72; color: white; }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-drumstick-bite"></i> KFC
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('menu') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('locations') }}">Locations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @if(app('App\Services\ApiService')->isAuthenticated())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-kfc ms-2" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-drumstick-bite"></i> KFC</h5>
                    <p>Finger Lickin' Good! Experience the best fried chicken and sides at KFC.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('menu') }}" class="text-light">Menu</a></li>
                        <li><a href="{{ route('locations') }}" class="text-light">Locations</a></li>
                        <li><a href="{{ route('about') }}" class="text-light">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <p><i class="fas fa-phone"></i> 1-800-CALL-KFC</p>
                    <p><i class="fas fa-envelope"></i> info@kfc.com</p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} KFC Restaurant Management. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>