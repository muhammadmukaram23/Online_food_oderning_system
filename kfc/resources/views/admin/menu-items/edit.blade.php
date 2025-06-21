@extends('layouts.app')

@section('title', 'Edit Menu Item - Admin Panel')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.menu-items') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-edit text-danger me-2"></i>
                        Edit Menu Item
                    </h2>
                    <p class="text-muted mb-0">Update {{ $menuItem['item_name'] ?? 'menu item' }} details</p>
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
                    <form method="POST" action="{{ route('admin.menu-items.update', $menuItem['item_id'] ?? 0) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="item_name" class="form-label">Item Name *</label>
                                    <input type="text" 
                                           class="form-control @error('item_name') is-invalid @enderror" 
                                           id="item_name" 
                                           name="item_name" 
                                           value="{{ old('item_name', $menuItem['item_name'] ?? '') }}" 
                                           required
                                           placeholder="e.g., Original Recipe Chicken">
                                    @error('item_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category *</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" 
                                            name="category_id" 
                                            required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category['category_id'] ?? '' }}" 
                                                    {{ old('category_id', $menuItem['category_id'] ?? '') == ($category['category_id'] ?? '') ? 'selected' : '' }}>
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

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Describe the menu item">{{ old('description', $menuItem['description'] ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price ($) *</label>
                                    <input type="number" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price', $menuItem['price'] ?? '') }}" 
                                           step="0.01"
                                           min="0"
                                           required
                                           placeholder="0.00">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="calories" class="form-label">Calories</label>
                                    <input type="number" 
                                           class="form-control @error('calories') is-invalid @enderror" 
                                           id="calories" 
                                           name="calories" 
                                           value="{{ old('calories', $menuItem['calories'] ?? '') }}" 
                                           min="0"
                                           placeholder="0">
                                    @error('calories')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="preparation_time" class="form-label">Prep Time (min)</label>
                                    <input type="number" 
                                           class="form-control @error('preparation_time') is-invalid @enderror" 
                                           id="preparation_time" 
                                           name="preparation_time" 
                                           value="{{ old('preparation_time', $menuItem['preparation_time'] ?? 10) }}" 
                                           min="1"
                                           placeholder="10">
                                    @error('preparation_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" 
                                           class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" 
                                           name="sort_order" 
                                           value="{{ old('sort_order', $menuItem['sort_order'] ?? 0) }}" 
                                           min="0"
                                           placeholder="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="ingredients" class="form-label">Ingredients</label>
                            <textarea class="form-control @error('ingredients') is-invalid @enderror" 
                                      id="ingredients" 
                                      name="ingredients" 
                                      rows="2"
                                      placeholder="List main ingredients (comma separated)">{{ old('ingredients', $menuItem['ingredients'] ?? '') }}</textarea>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="allergens" class="form-label">Allergens</label>
                            <input type="text" 
                                   class="form-control @error('allergens') is-invalid @enderror" 
                                   id="allergens" 
                                   name="allergens" 
                                   value="{{ old('allergens', $menuItem['allergens'] ?? '') }}" 
                                   placeholder="e.g., Contains: Wheat, Soy, Eggs">
                            @error('allergens')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Item Image</label>
                            
                            @if($menuItem['image_url'] ?? false)
                                <div class="mb-3">
                                    <img src="{{ $menuItem['image_url'] }}" 
                                         alt="Current Image" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px; max-height: 200px;">
                                    <div class="form-text">Current image</div>
                                </div>
                            @endif
                            
                            <input type="file" 
                                   class="form-control @error('image') is-invalid @enderror" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Upload a new image to replace the current one (JPG, PNG, GIF - Max 2MB)</div>
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                <div class="form-text">New image preview</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="is_available" 
                                               name="is_available" 
                                               value="1"
                                               {{ old('is_available', $menuItem['is_available'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_available">
                                            Available for order
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="featured" 
                                               name="featured" 
                                               value="1"
                                               {{ old('featured', $menuItem['featured'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured">
                                            Featured item
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="is_vegetarian" 
                                               name="is_vegetarian" 
                                               value="1"
                                               {{ old('is_vegetarian', $menuItem['is_vegetarian'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_vegetarian">
                                            Vegetarian
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" 
                                               class="form-check-input" 
                                               id="is_spicy" 
                                               name="is_spicy" 
                                               value="1"
                                               {{ old('is_spicy', $menuItem['is_spicy'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_spicy">
                                            Spicy
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.menu-items') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-kfc">
                                <i class="fas fa-save me-2"></i>Update Menu Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewDiv.style.display = 'none';
    }
}
</script>
@endsection 