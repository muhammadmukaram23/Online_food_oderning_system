@extends('layouts.app')

@section('title', 'Admin Dashboard - KFC')

@section('content')
<div class="admin-header">
    <div class="container">
        <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
        <p>Welcome to your KFC Restaurant Management System</p>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <nav class="nav flex-column">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link" href="{{ route('admin.locations') }}">
                    <i class="fas fa-map-marker-alt"></i> Locations
                </a>
                <a class="nav-link" href="{{ route('admin.categories') }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
                <a class="nav-link" href="{{ route('admin.menu-items') }}">
                    <i class="fas fa-utensils"></i> Menu Items
                </a>
                <a class="nav-link" href="{{ route('admin.orders') }}">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card text-center">
                        <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                        <h3>{{ $statsData['locations'] ?? 0 }}</h3>
                        <p class="mb-0">Locations</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card text-center">
                        <i class="fas fa-tags fa-2x mb-2"></i>
                        <h3>{{ $statsData['categories'] ?? 0 }}</h3>
                        <p class="mb-0">Categories</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card text-center">
                        <i class="fas fa-utensils fa-2x mb-2"></i>
                        <h3>{{ $statsData['menu_items'] ?? 0 }}</h3>
                        <p class="mb-0">Menu Items</p>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="stats-card text-center">
                        <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                        <h3>{{ $statsData['orders'] ?? 0 }}</h3>
                        <p class="mb-0">Orders</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.locations.create') }}" class="btn btn-outline-kfc w-100">
                                        <i class="fas fa-plus"></i><br>
                                        Add Location
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-kfc w-100">
                                        <i class="fas fa-plus"></i><br>
                                        Add Category
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.menu-items.create') }}" class="btn btn-outline-kfc w-100">
                                        <i class="fas fa-plus"></i><br>
                                        Add Menu Item
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.orders') }}" class="btn btn-outline-kfc w-100">
                                        <i class="fas fa-list"></i><br>
                                        View Orders
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-chart-line"></i> System Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>API Connection</span>
                                <span class="badge bg-success">Connected</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Database</span>
                                <span class="badge bg-success">Active</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Total Customers</span>
                                <span class="badge bg-info">{{ $statsData['customers'] ?? 0 }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>System Health</span>
                                <span class="badge bg-success">Excellent</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Getting Started</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Set up your restaurant locations
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Create menu categories
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Add delicious menu items
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i>
                                    Start managing orders
                                </li>
                            </ul>
                            <a href="{{ route('admin.locations.create') }}" class="btn btn-kfc btn-sm">
                                Get Started <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 