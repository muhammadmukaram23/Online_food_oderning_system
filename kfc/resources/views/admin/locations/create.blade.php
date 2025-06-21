@extends('layouts.app')

@section('title', 'Add New Location - Admin Panel')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.locations') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                        Add New Location
                    </h2>
                    <p class="text-muted mb-0">Create a new KFC store location</p>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <h6 class="fw-bold mb-2">Please fix the following errors:</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.locations.store') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="store_name" class="form-label">Store Name *</label>
                                    <input type="text" 
                                           class="form-control @error('store_name') is-invalid @enderror" 
                                           id="store_name" 
                                           name="store_name" 
                                           value="{{ old('store_name') }}" 
                                           required
                                           placeholder="e.g., KFC Downtown">
                                    @error('store_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="manager_name" class="form-label">Manager Name *</label>
                                    <input type="text" 
                                           class="form-control @error('manager_name') is-invalid @enderror" 
                                           id="manager_name" 
                                           name="manager_name" 
                                           value="{{ old('manager_name') }}" 
                                           required
                                           placeholder="Manager full name">
                                    @error('manager_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Street Address *</label>
                            <input type="text" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   id="address" 
                                   name="address" 
                                   value="{{ old('address') }}" 
                                   required
                                   placeholder="Street address">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City *</label>
                                    <input type="text" 
                                           class="form-control @error('city') is-invalid @enderror" 
                                           id="city" 
                                           name="city" 
                                           value="{{ old('city') }}" 
                                           required
                                           placeholder="City name">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State *</label>
                                    <input type="text" 
                                           class="form-control @error('state') is-invalid @enderror" 
                                           id="state" 
                                           name="state" 
                                           value="{{ old('state') }}" 
                                           required
                                           placeholder="State">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="zip_code" class="form-label">ZIP Code *</label>
                                    <input type="text" 
                                           class="form-control @error('zip_code') is-invalid @enderror" 
                                           id="zip_code" 
                                           name="zip_code" 
                                           value="{{ old('zip_code') }}" 
                                           required
                                           placeholder="ZIP Code">
                                    @error('zip_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number *</label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           required
                                           placeholder="(555) 123-4567">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="store@kfc.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="opening_time" class="form-label">Opening Time</label>
                                    <input type="time" 
                                           class="form-control @error('opening_time') is-invalid @enderror" 
                                           id="opening_time" 
                                           name="opening_time" 
                                           value="{{ old('opening_time', '06:00') }}">
                                    @error('opening_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="closing_time" class="form-label">Closing Time</label>
                                    <input type="time" 
                                           class="form-control @error('closing_time') is-invalid @enderror" 
                                           id="closing_time" 
                                           name="closing_time" 
                                           value="{{ old('closing_time', '23:00') }}">
                                    @error('closing_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Store is active and operational
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.locations') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-kfc">
                                <i class="fas fa-save me-2"></i>Create Location
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 