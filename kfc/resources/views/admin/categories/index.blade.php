@extends('layouts.app')

@section('title', 'Categories - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-tags text-danger me-2"></i>
                        Menu Categories
                    </h2>
                    <p class="text-muted mb-0">Manage KFC menu categories</p>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-kfc">
                    <i class="fas fa-plus me-2"></i>Add New Category
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    @if(count($categories) > 0)
                        <div class="row">
                            @foreach($categories as $category)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        @if($category['image_url'] ?? false)
                                            <img src="{{ $category['image_url'] }}" 
                                                 class="card-img-top" 
                                                 alt="{{ $category['category_name'] ?? 'Category' }}"
                                                 style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                 style="height: 200px;">
                                                <i class="fas fa-image fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="card-title fw-bold mb-0">
                                                    {{ $category['category_name'] ?? 'Unnamed Category' }}
                                                </h5>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-secondary me-2">
                                                        #{{ $category['category_id'] ?? 'N/A' }}
                                                    </span>
                                                    @if(($category['is_active'] ?? true))
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if($category['description'] ?? false)
                                                <p class="card-text text-muted small flex-grow-1">
                                                    {{ Str::limit($category['description'], 100) }}
                                                </p>
                                            @else
                                                <p class="card-text text-muted small flex-grow-1">
                                                    No description available
                                                </p>
                                            @endif
                                            
                                            <div class="mt-auto">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        Sort: {{ $category['sort_order'] ?? 0 }}
                                                    </small>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.categories.edit', $category['category_id'] ?? 0) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form method="POST" 
                                                              action="{{ route('admin.categories.destroy', $category['category_id'] ?? 0) }}" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Categories Found</h4>
                            <p class="text-muted mb-4">Start by creating your first menu category.</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-kfc">
                                <i class="fas fa-plus me-2"></i>Add First Category
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 