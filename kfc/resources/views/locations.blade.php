@extends('layouts.app')

@section('title', 'Our Locations - KFC')

@section('content')
<div class="container-fluid py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 fw-bold text-dark mb-3">
                <i class="fas fa-map-marker-alt text-danger me-3"></i>
                Find Your Nearest KFC
            </h1>
            <p class="lead text-muted">
                Discover our finger lickin' good restaurants near you
            </p>
        </div>
    </div>

    <!-- Locations Grid -->
    <div class="container">
        <div class="row">
            @if(count($locations) > 0)
                @foreach($locations as $location)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title fw-bold text-dark mb-0">
                                        {{ $location['store_name'] ?? 'KFC Store' }}
                                    </h5>
                                    @if(($location['is_active'] ?? true))
                                        <span class="badge bg-success">Open</span>
                                    @else
                                        <span class="badge bg-danger">Closed</span>
                                    @endif
                                </div>
                                
                                <div class="mb-3">
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                        {{ $location['address'] ?? 'Address not available' }}
                                    </p>
                                    <p class="text-muted mb-2">
                                        {{ $location['city'] ?? ''}}{{ $location['city'] && $location['state'] ? ', ' : '' }}{{ $location['state'] ?? '' }} {{ $location['zip_code'] ?? '' }}
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-phone me-2 text-danger"></i>
                                        {{ $location['phone'] ?? 'Phone not available' }}
                                    </p>
                                    @if($location['email'] ?? false)
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-envelope me-2 text-danger"></i>
                                            {{ $location['email'] }}
                                        </p>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-user-tie me-2 text-danger"></i>
                                        Manager: {{ $location['manager_name'] ?? 'Not specified' }}
                                    </p>
                                </div>

                                @if(($location['opening_time'] ?? false) && ($location['closing_time'] ?? false))
                                    <div class="mb-3">
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-clock me-2 text-danger"></i>
                                            <strong>Hours:</strong> 
                                            {{ date('g:i A', strtotime($location['opening_time'])) }} - 
                                            {{ date('g:i A', strtotime($location['closing_time'])) }}
                                        </p>
                                    </div>
                                @endif

                                <div class="mt-auto">
                                    <div class="d-flex gap-2">
                                        @if($location['address'] ?? false)
                                            <a href="https://maps.google.com/?q={{ urlencode(($location['address'] ?? '') . ' ' . ($location['city'] ?? '') . ' ' . ($location['state'] ?? '')) }}" 
                                               target="_blank" 
                                               class="btn btn-outline-danger btn-sm flex-fill">
                                                <i class="fas fa-directions me-1"></i>
                                                Get Directions
                                            </a>
                                        @endif
                                        @if($location['phone'] ?? false)
                                            <a href="tel:{{ $location['phone'] }}" 
                                               class="btn btn-kfc btn-sm flex-fill">
                                                <i class="fas fa-phone me-1"></i>
                                                Call Now
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-map-marker-alt fa-3x text-muted mb-4"></i>
                        <h3 class="text-muted mb-3">No Locations Available</h3>
                        <p class="text-muted">
                            We're working on expanding our locations. Check back soon!
                        </p>
                        <a href="{{ route('home') }}" class="btn btn-kfc mt-3">
                            <i class="fas fa-home me-2"></i>
                            Back to Home
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="bg-light py-5 mt-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-3">Can't Find Your Location?</h3>
        <p class="text-muted mb-4">
            We're always looking to serve more communities. Let us know where you'd like to see a KFC!
        </p>
        <a href="{{ route('contact') }}" class="btn btn-kfc">
            <i class="fas fa-envelope me-2"></i>
            Contact Us
        </a>
    </div>
</div>
@endsection 