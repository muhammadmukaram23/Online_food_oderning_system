@extends('layouts.app')

@section('title', 'Menu - KFC')

@section('content')
<!-- Header -->
<div class="hero-section py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">
            <i class="fas fa-utensils"></i> Our Menu
        </h1>
        <p class="lead">Discover our finger lickin' good menu items</p>
    </div>
</div>

<div class="container py-5">
    <!-- Category Filter -->
    @if(count($categories) > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-filter"></i> Filter by Category
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('menu') }}" 
                               class="btn {{ !$categoryId ? 'btn-kfc' : 'btn-outline-secondary' }}">
                                All Items
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('menu', ['category' => $category['category_id']]) }}" 
                                   class="btn {{ $categoryId == $category['category_id'] ? 'btn-kfc' : 'btn-outline-secondary' }}">
                                    {{ $category['category_name'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Menu Items -->
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
                                <h5 class="card-title">{{ $item['item_name'] ?? 'Unknown Item' }}</h5>
                                <span class="price-tag">${{ number_format($item['price'], 2) }}</span>
                            </div>
                            
                            @if(isset($item['description']) && $item['description'])
                                <p class="card-text text-muted">{{ $item['description'] }}</p>
                            @endif
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        @if(isset($item['category']) && $item['category'])
                                            <span class="badge bg-secondary">{{ $item['category']['category_name'] ?? 'Category' }}</span>
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
                                </div>
                                
                                @if(isset($item['is_available']) && $item['is_available'])
                                    <button class="btn btn-kfc w-100" onclick="addToCart('{{ $item['item_name'] ?? 'Unknown Item' }}', {{ $item['price'] }})">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </button>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-times"></i> Unavailable
                                    </button>
                                @endif
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
            @if($categoryId)
                <p class="text-muted">No items found in this category.</p>
                <a href="{{ route('menu') }}" class="btn btn-kfc">
                    <i class="fas fa-utensils"></i> View All Items
                </a>
            @else
                <p class="text-muted">Our menu is being updated. Please check back soon!</p>
            @endif
        </div>
    @endif

    <!-- Categories Section (if no items) -->
    @if(count($menuItems) == 0 && count($categories) > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="text-center mb-4">Browse Categories</h3>
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-utensils fa-3x text-danger mb-3"></i>
                                    <h5 class="card-title">{{ $category['category_name'] ?? 'Unknown Category' }}</h5>
                                    @if(isset($category['description']) && $category['description'])
                                        <p class="card-text text-muted">{{ $category['description'] }}</p>
                                    @endif
                                    <a href="{{ route('menu', ['category' => $category['category_id']]) }}" 
                                       class="btn btn-outline-kfc">
                                        View Items
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Cart Modal (placeholder for future implementation) -->
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-shopping-cart"></i> Cart
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="cartItems">
                    <p class="text-muted text-center">Your cart is empty</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Shopping</button>
                <button type="button" class="btn btn-kfc" id="checkoutBtn" disabled>
                    <i class="fas fa-credit-card"></i> Checkout
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let cart = [];

function addToCart(itemName, price) {
    // Check if item already exists in cart
    const existingItem = cart.find(item => item.name === itemName);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            name: itemName,
            price: price,
            quantity: 1
        });
    }
    
    updateCartDisplay();
    showCartNotification(itemName);
}

function updateCartDisplay() {
    const cartItems = document.getElementById('cartItems');
    const checkoutBtn = document.getElementById('checkoutBtn');
    
    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="text-muted text-center">Your cart is empty</p>';
        checkoutBtn.disabled = true;
        return;
    }
    
    let cartHTML = '';
    let total = 0;
    
    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        cartHTML += `
            <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                <div>
                    <h6 class="mb-0">${item.name}</h6>
                    <small class="text-muted">$${item.price.toFixed(2)} each</small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                    <span class="fw-bold">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                    <span class="fw-bold ms-2">$${itemTotal.toFixed(2)}</span>
                    <button class="btn btn-sm btn-outline-danger ms-2" onclick="removeFromCart(${index})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    cartHTML += `
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Total: $${total.toFixed(2)}</h5>
        </div>
    `;
    
    cartItems.innerHTML = cartHTML;
    checkoutBtn.disabled = false;
}

function updateQuantity(index, change) {
    cart[index].quantity += change;
    
    if (cart[index].quantity <= 0) {
        cart.splice(index, 1);
    }
    
    updateCartDisplay();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartDisplay();
}

function showCartNotification(itemName) {
    // Create a toast notification
    const toastHTML = `
        <div class="toast align-items-center text-white bg-success border-0 position-fixed" 
             style="top: 100px; right: 20px; z-index: 1050;" 
             role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle"></i> ${itemName} added to cart!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', toastHTML);
    
    const toastElement = document.querySelector('.toast:last-child');
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Remove the toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

// Show cart modal when cart button is clicked
document.addEventListener('DOMContentLoaded', function() {
    // Add cart button to navbar if it doesn't exist
    const navbar = document.querySelector('.navbar-nav:last-child');
    if (navbar && !document.getElementById('cartButton')) {
        const cartButton = document.createElement('li');
        cartButton.className = 'nav-item';
        cartButton.innerHTML = `
            <button class="nav-link btn btn-link" id="cartButton" data-bs-toggle="modal" data-bs-target="#cartModal">
                <i class="fas fa-shopping-cart"></i> Cart (<span id="cartCount">0</span>)
            </button>
        `;
        navbar.insertBefore(cartButton, navbar.firstChild);
    }
    
    // Update cart count
    function updateCartCount() {
        const cartCount = document.getElementById('cartCount');
        if (cartCount) {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
        }
    }
    
    // Override the original addToCart function to update count
    const originalAddToCart = window.addToCart;
    window.addToCart = function(itemName, price) {
        originalAddToCart(itemName, price);
        updateCartCount();
    };
});
</script>
@endpush
@endsection 