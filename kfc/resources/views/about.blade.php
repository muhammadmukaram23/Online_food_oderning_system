@extends('layouts.app')

@section('title', 'About Us - KFC')

@section('content')
<!-- Hero Section -->
<div class="bg-dark text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4">
                    It's Finger Lickin' Good!
                </h1>
                <p class="lead mb-4">
                    For over 90 years, KFC has been serving up the Original Recipe chicken with 
                    11 herbs and spices that made us famous.
                </p>
                <a href="{{ route('menu') }}" class="btn btn-kfc btn-lg">
                    <i class="fas fa-utensils me-2"></i>
                    Explore Our Menu
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-drumstick-bite fa-5x text-danger"></i>
            </div>
        </div>
    </div>
</div>

<!-- Our Story Section -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto text-center">
            <h2 class="display-5 fw-bold mb-4">Our Story</h2>
            <p class="lead text-muted mb-5">
                From humble beginnings to becoming the world's most popular chicken restaurant chain, 
                KFC has always been about serving delicious, quality food with a smile.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-alt fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Founded in 1930</h5>
                    <p class="text-muted">
                        Colonel Harland Sanders began serving fried chicken from his roadside restaurant 
                        in Corbin, Kentucky, during the Great Depression.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-globe fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Global Presence</h5>
                    <p class="text-muted">
                        Today, KFC serves millions of customers in over 145 countries and territories 
                        around the world every day.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-award fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Secret Recipe</h5>
                    <p class="text-muted">
                        Our Original Recipe of 11 herbs and spices remains one of the best-kept 
                        secrets in the food industry.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Colonel Sanders Section -->
<div class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold mb-4">Meet The Colonel</h2>
                <p class="mb-4">
                    Colonel Harland David Sanders was an American businessman, best known for founding 
                    fast food chicken restaurant chain Kentucky Fried Chicken (now known as KFC) and 
                    later acting as the company's brand ambassador and symbol.
                </p>
                <p class="mb-4">
                    His name and image are still symbols of the company. The Colonel's original recipe 
                    of 11 herbs and spices is still used today and remains a closely guarded secret.
                </p>
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h3 class="fw-bold text-danger">1930</h3>
                            <p class="small text-muted">Started cooking</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h3 class="fw-bold text-danger">65</h3>
                            <p class="small text-muted">Age when KFC began</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 300px; height: 300px;">
                    <i class="fas fa-user-tie fa-5x text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Our Values Section -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto text-center mb-5">
            <h2 class="display-5 fw-bold mb-4">Our Values</h2>
            <p class="lead text-muted">
                These core values guide everything we do, from how we prepare our food to how we treat our customers and communities.
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center">
                <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-heart fa-2x"></i>
                </div>
                <h5 class="fw-bold">Quality</h5>
                <p class="text-muted">
                    We're committed to serving the highest quality food with fresh ingredients and time-tested recipes.
                </p>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center">
                <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <h5 class="fw-bold">Service</h5>
                <p class="text-muted">
                    Every customer deserves friendly, fast service and a positive dining experience.
                </p>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center">
                <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-handshake fa-2x"></i>
                </div>
                <h5 class="fw-bold">Community</h5>
                <p class="text-muted">
                    We're proud to be part of local communities and give back through various initiatives.
                </p>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center">
                <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px;">
                    <i class="fas fa-leaf fa-2x"></i>
                </div>
                <h5 class="fw-bold">Sustainability</h5>
                <p class="text-muted">
                    We're committed to responsible sourcing and reducing our environmental impact.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="bg-dark text-white py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <h2 class="display-4 fw-bold text-danger">25,000+</h2>
                <p class="lead">Restaurants Worldwide</p>
            </div>
            <div class="col-md-3 mb-4">
                <h2 class="display-4 fw-bold text-danger">145+</h2>
                <p class="lead">Countries & Territories</p>
            </div>
            <div class="col-md-3 mb-4">
                <h2 class="display-4 fw-bold text-danger">1M+</h2>
                <p class="lead">Team Members</p>
            </div>
            <div class="col-md-3 mb-4">
                <h2 class="display-4 fw-bold text-danger">90+</h2>
                <p class="lead">Years of Excellence</p>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto text-center">
            <h2 class="display-5 fw-bold mb-4">Ready to Experience KFC?</h2>
            <p class="lead text-muted mb-4">
                Join millions of satisfied customers worldwide and taste what makes us special.
            </p>
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                <a href="{{ route('locations') }}" class="btn btn-kfc btn-lg">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Find a Location
                </a>
                <a href="{{ route('menu') }}" class="btn btn-outline-danger btn-lg">
                    <i class="fas fa-utensils me-2"></i>
                    View Menu
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 