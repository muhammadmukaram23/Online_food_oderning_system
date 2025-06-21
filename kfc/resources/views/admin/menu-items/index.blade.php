@extends('layouts.app')

@section('title', 'Menu Items - Admin')

@section('content')
<div class="admin-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-utensils"></i> Menu Items</h1>
                <p>Manage your delicious KFC menu items</p>
            </div>
            <a href="{{ route('admin.menu-items.create') }}" class="btn btn-light btn-lg">
                <i class="fas fa-plus"></i> Add Menu Item
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <nav class="nav flex-column">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link" href="{{ route('admin.locations') }}">
                    <i class="fas fa-map-marker-alt"></i> Locations
                </a>
                <a class="nav-link" href="{{ route('admin.categories') }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
                <a class="nav-link active" href="{{ route('admin.menu-items') }}">
                    <i class="fas fa-utensils"></i> Menu Items
                </a>
                <a class="nav-link" href="{{ route('admin.orders') }}">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <!-- Filter Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.menu-items') }}">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label for="category_id" class="form-label">Filter by Category</label>
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category['category_id'] }}" 
                                                {{ $categoryId == $category['category_id'] ? 'selected' : '' }}>
                                            {{ $category['category_name'] ?? 'Unknown Category' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-outline-kfc">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.menu-items') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Menu Items Grid -->
            @if(count($menuItems) > 0)
                <div class="row">
                    @foreach($menuItems as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card menu-item-card h-100">
                                @if(isset($item['image_url']) && $item['image_url'])
                                    <img src="{{ $item['image_url'] }}" class="card-img-top" alt="{{ $item['item_name'] ?? 'Menu Item' }}">
                                @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                        <i class="fas fa-utensils fa-3x text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ $item['item_name'] ?? 'Unknown Item' }}</h5>
                                        <span class="price-tag">${{ number_format($item['price'], 2) }}</span>
                                    </div>
                                    
                                    @if(isset($item['description']) && $item['description'])
                                        <p class="card-text text-muted small">{{ Str::limit($item['description'], 100) }}</p>
                                    @endif
                                    
                                    <div class="mb-2">
                                        @if(isset($item['category']) && $item['category'])
                                            <span class="badge bg-secondary">{{ $item['category']['category_name'] ?? 'Unknown Category' }}</span>
                                        @endif
                                        
                                        @if(isset($item['is_available']) && $item['is_available'])
                                            <span class="badge bg-success">Available</span>
                                        @else
                                            <span class="badge bg-danger">Unavailable</span>
                                        @endif
                                        
                                        @if(isset($item['featured']) && $item['featured'])
                                            <span class="badge bg-warning">Featured</span>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-auto">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.menu-items.edit', $item['item_id']) }}" 
                                               class="btn btn-outline-primary btn-sm flex-fill">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" 
                                                  action="{{ route('admin.menu-items.destroy', $item['item_id']) }}" 
                                                  class="flex-fill"
                                                  onsubmit="return confirm('Are you sure you want to delete this menu item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-utensils fa-5x text-muted mb-3"></i>
                    <h3 class="text-muted">No Menu Items Found</h3>
                    <p class="text-muted">Start by adding your first delicious menu item!</p>
                    <a href="{{ route('admin.menu-items.create') }}" class="btn btn-kfc btn-lg">
                        <i class="fas fa-plus"></i> Add First Menu Item
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 