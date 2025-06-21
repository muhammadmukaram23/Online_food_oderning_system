@extends('layouts.app')

@section('title', 'KFC - Finger Lickin\' Good!')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    <i class="fas fa-drumstick-bite"></i>
                    It's Finger Lickin' Good!
                </h1>
                <p class="lead mb-4">
                    Experience the world's most delicious fried chicken and sides. 
                    Made with our secret blend of 11 herbs and spices.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('menu') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-utensils"></i> View Menu
                    </a>
                    <a href="{{ route('locations') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-map-marker-alt"></i> Find Location
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-drumstick-bite" style="font-size: 12rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Featured Items -->
@if(count($featuredItems) > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Featured Items</h2>
            <p class="lead text-muted">Try our most popular and delicious menu items</p>
        </div>
        
        <div class="row">
            @foreach($featuredItems as $item)
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
                                <h5 class="card-title">{{ $item['item_name'] ?? 'Unknown Item' }}</h5>
                                <span class="price-tag">${{ number_format($item['price'], 2) }}</span>
                            </div>
                            
                            @if(isset($item['description']) && $item['description'])
                                <p class="card-text text-muted flex-fill">{{ Str::limit($item['description'], 100) }}</p>
                            @endif
                            
                            <div class="mt-auto">
                                @if(isset($item['category']) && $item['category'])
                                    <small class="text-muted">
                                        <i class="fas fa-tag"></i> {{ $item['category']['category_name'] ?? 'Category' }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('menu') }}" class="btn btn-kfc btn-lg">
                <i class="fas fa-utensils"></i> View Full Menu
            </a>
        </div>
    </div>
</section>
@endif

<!-- Categories Section -->
@if(count($categories) > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Menu Categories</h2>
            <p class="lead text-muted">Explore our delicious food categories</p>
        </div>
        
        <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card text-center h-100">
                        <div class="card-body d-flex flex-column">
                            <i class="fas fa-utensils fa-3x text-danger mb-3"></i>
                            <h5 class="card-title">{{ $category['category_name'] ?? 'Unknown Category' }}</h5>
                            @if(isset($category['description']) && $category['description'])
                                <p class="card-text text-muted flex-fill">{{ $category['description'] }}</p>
                            @endif
                            <a href="{{ route('menu', ['category' => $category['category_id']]) }}" 
                               class="btn btn-outline-kfc mt-auto">
                                View Items
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Locations Section -->
@if(count($locations) > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Our Locations</h2>
            <p class="lead text-muted">Find a KFC restaurant near you</p>
        </div>
        
        <div class="row">
            @foreach(array_slice($locations, 0, 3) as $location)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                {{ $location['store_name'] ?? 'Unknown Location' }}
                            </h5>
                            <p class="card-text">
                                <strong>Address:</strong><br>
                                {{ $location['address'] }}<br>
                                {{ $location['city'] }}, {{ $location['state'] }}
                            </p>
                            @if(isset($location['phone']) && $location['phone'])
                                <p class="card-text">
                                    <i class="fas fa-phone"></i> {{ $location['phone'] }}
                                </p>
                            @endif
                            @if(isset($location['opening_hours']) && $location['opening_hours'])
                                <p class="card-text">
                                    <i class="fas fa-clock"></i> {{ $location['opening_hours'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('locations') }}" class="btn btn-outline-kfc btn-lg">
                <i class="fas fa-map-marker-alt"></i> View All Locations
            </a>
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-3">Ready to Order?</h2>
                <p class="lead text-muted mb-4">
                    Join millions of satisfied customers who love our finger lickin' good chicken!
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('menu') }}" class="btn btn-kfc btn-lg">
                        <i class="fas fa-shopping-cart"></i> Order Now
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-info-circle"></i> Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 