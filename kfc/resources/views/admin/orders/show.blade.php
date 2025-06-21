@extends('layouts.app')

@section('title', 'Order Details - Admin Panel')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-receipt text-danger me-2"></i>
                        Order Details
                    </h2>
                    <p class="text-muted mb-0">
                        Order {{ $order['order_number'] ?? '#' . ($order['order_id'] ?? 'N/A') }}
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Order Information -->
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2"></i>Order Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Order Number:</td>
                                            <td>{{ $order['order_number'] ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Customer:</td>
                                            <td>
                                                @if($order['customer_id'] ?? false)
                                                    Customer #{{ $order['customer_id'] }}
                                                @else
                                                    <span class="text-muted">Guest Order</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Order Type:</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $order['order_type'] ?? 'N/A' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Location:</td>
                                            <td>Location #{{ $order['location_id'] ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Status:</td>
                                            <td>
                                                @php
                                                    $status = $order['order_status'] ?? 'Pending';
                                                    $badgeClass = match($status) {
                                                        'Pending' => 'bg-warning',
                                                        'Confirmed' => 'bg-info',
                                                        'Preparing' => 'bg-primary',
                                                        'Ready' => 'bg-success',
                                                        'Out for Delivery' => 'bg-secondary',
                                                        'Delivered' => 'bg-success',
                                                        'Cancelled' => 'bg-danger',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Payment Status:</td>
                                            <td>
                                                @php
                                                    $paymentStatus = $order['payment_status'] ?? 'Pending';
                                                    $paymentBadgeClass = match($paymentStatus) {
                                                        'Paid' => 'bg-success',
                                                        'Pending' => 'bg-warning',
                                                        'Failed' => 'bg-danger',
                                                        'Refunded' => 'bg-secondary',
                                                        default => 'bg-secondary'
                                                    };
                                                @endphp
                                                <span class="badge {{ $paymentBadgeClass }}">
                                                    {{ $paymentStatus }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Order Date:</td>
                                            <td>
                                                {{ isset($order['created_at']) ? \Carbon\Carbon::parse($order['created_at'])->format('M d, Y h:i A') : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Prep Time:</td>
                                            <td>
                                                Est: {{ $order['estimated_prep_time'] ?? 'N/A' }} min
                                                @if($order['actual_prep_time'] ?? false)
                                                    <br><small class="text-muted">Actual: {{ $order['actual_prep_time'] }} min</small>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            @if($order['special_instructions'] ?? false)
                                <div class="mt-3">
                                    <h6 class="fw-bold">Special Instructions:</h6>
                                    <div class="alert alert-info">
                                        <i class="fas fa-sticky-note me-2"></i>
                                        {{ $order['special_instructions'] }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-utensils me-2"></i>Order Items
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(count($orderItems) > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                                <th>Special Instructions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orderItems as $item)
                                                <tr>
                                                    <td>
                                                        <div class="fw-bold">Item #{{ $item['item_id'] ?? 'N/A' }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">
                                                            {{ $item['quantity'] ?? 1 }}
                                                        </span>
                                                    </td>
                                                    <td>${{ number_format($item['unit_price'] ?? 0, 2) }}</td>
                                                    <td class="fw-bold text-success">
                                                        ${{ number_format($item['total_price'] ?? 0, 2) }}
                                                    </td>
                                                    <td>
                                                        @if($item['special_instructions'] ?? false)
                                                            <small class="text-muted">
                                                                {{ $item['special_instructions'] }}
                                                            </small>
                                                        @else
                                                            <span class="text-muted">None</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-utensils fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">No items found for this order.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Actions -->
                <div class="col-md-4">
                    <!-- Order Summary -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calculator me-2"></i>Order Summary
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <td>Subtotal:</td>
                                    <td class="text-end">${{ number_format($order['subtotal'] ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Tax:</td>
                                    <td class="text-end">${{ number_format($order['tax_amount'] ?? 0, 2) }}</td>
                                </tr>
                                @if(($order['delivery_fee'] ?? 0) > 0)
                                    <tr>
                                        <td>Delivery Fee:</td>
                                        <td class="text-end">${{ number_format($order['delivery_fee'], 2) }}</td>
                                    </tr>
                                @endif
                                @if(($order['discount_amount'] ?? 0) > 0)
                                    <tr class="text-success">
                                        <td>Discount:</td>
                                        <td class="text-end">-${{ number_format($order['discount_amount'], 2) }}</td>
                                    </tr>
                                @endif
                                <tr class="border-top">
                                    <td class="fw-bold">Total:</td>
                                    <td class="text-end fw-bold text-success fs-5">
                                        ${{ number_format($order['total_amount'] ?? 0, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cogs me-2"></i>Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            @if(($order['order_status'] ?? 'Pending') !== 'Delivered' && ($order['order_status'] ?? 'Pending') !== 'Cancelled')
                                <button type="button" 
                                        class="btn btn-kfc w-100 mb-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#statusModal">
                                    <i class="fas fa-edit me-2"></i>Update Status
                                </button>
                            @endif
                            
                            <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i>Back to Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusModalLabel">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.orders.update-status', $order['order_id'] ?? 0) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">New Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Pending" {{ ($order['order_status'] ?? 'Pending') === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Confirmed" {{ ($order['order_status'] ?? 'Pending') === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="Preparing" {{ ($order['order_status'] ?? 'Pending') === 'Preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="Ready" {{ ($order['order_status'] ?? 'Pending') === 'Ready' ? 'selected' : '' }}>Ready</option>
                            <option value="Out for Delivery" {{ ($order['order_status'] ?? 'Pending') === 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                            <option value="Delivered" {{ ($order['order_status'] ?? 'Pending') === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="Cancelled" {{ ($order['order_status'] ?? 'Pending') === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-kfc">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 