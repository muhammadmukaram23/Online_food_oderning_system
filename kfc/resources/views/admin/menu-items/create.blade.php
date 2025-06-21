@extends('layouts.app')

@section('title', 'Add Menu Item - Admin')

@section('content')
<div class="admin-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-plus"></i> Add Menu Item</h1>
                <p>Create a new delicious menu item</p>
            </div>
            <a href="{{ route('admin.menu-items') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Back to Menu Items
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
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.menu-items.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="item_name" class="form-label">Item Name *</label>
                                            <input type="text" 
                                                   class="form-control @error('item_name') is-invalid @enderror" 
                                                   id="item_name" 
                                                   name="item_name" 
                                                   value="{{ old('item_name') }}" 
                                                   required
                                                   placeholder="e.g., Original Recipe Chicken">
                                            @error('item_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" 
                                                      name="description" 
                                                      rows="4"
                                                      placeholder="Describe this delicious menu item...">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="price" class="form-label">Price ($) *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">$</span>
                                                        <input type="number" 
                                                               class="form-control @error('price') is-invalid @enderror" 
                                                               id="price" 
                                                               name="price" 
                                                               value="{{ old('price') }}" 
                                                               step="0.01"
                                                               min="0"
                                                               required
                                                               placeholder="0.00">
                                                    </div>
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="category_id" class="form-label">Category *</label>
                                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                                            id="category_id" 
                                                            name="category_id" 
                                                            required>
                                                        <option value="">Select a category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category['category_id'] }}" 
                                                                    {{ old('category_id') == $category['category_id'] ? 'selected' : '' }}>
                                                                {{ $category['category_name'] ?? 'Unknown Category' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('category_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Options -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-cog"></i> Options</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           id="is_available" 
                                                           name="is_available"
                                                           {{ old('is_available', true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_available">
                                                        <strong>Available for Order</strong>
                                                        <br><small class="text-muted">Customers can order this item</small>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" 
                                                           type="checkbox" 
                                                           id="is_featured" 
                                                           name="is_featured"
                                                           {{ old('is_featured') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_featured">
                                                        <strong>Featured Item</strong>
                                                        <br><small class="text-muted">Show on homepage</small>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0"><i class="fas fa-image"></i> Item Image</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div class="image-preview mb-3" id="imagePreview">
                                            <i class="fas fa-utensils fa-5x text-muted"></i>
                                            <p class="text-muted mt-2">No image selected</p>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <input type="file" 
                                                   class="form-control @error('image') is-invalid @enderror" 
                                                   id="image" 
                                                   name="image" 
                                                   accept="image/*"
                                                   onchange="previewImage(this)">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <small class="text-muted">
                                            Supported formats: JPG, PNG, GIF<br>
                                            Maximum size: 2MB
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('admin.menu-items') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-kfc btn-lg">
                                <i class="fas fa-save"></i> Create Menu Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" 
                     class="img-fluid rounded" 
                     style="max-height: 200px; object-fit: cover;" 
                     alt="Preview">
                <p class="text-success mt-2 mb-0">
                    <i class="fas fa-check-circle"></i> Image selected
                </p>
            `;
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.innerHTML = `
            <i class="fas fa-utensils fa-5x text-muted"></i>
            <p class="text-muted mt-2">No image selected</p>
        `;
    }
}
</script>
@endpush
@endsection
