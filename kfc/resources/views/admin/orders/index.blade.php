@extends('layouts.app')

@section('title', 'Orders - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-shopping-cart text-danger me-2"></i>
                        Orders Management
                    </h2>
                    <p class="text-muted mb-0">View and manage all customer orders</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-2"></i>Refresh
                    </button>
                </div>
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
                    @if(count($orders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <span class="fw-bold text-primary">
                                                    {{ $order['order_number'] ?? '#' . ($order['order_id'] ?? 'N/A') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($order['customer_id'] ?? false)
                                                    <div class="fw-bold">Customer #{{ $order['customer_id'] }}</div>
                                                @else
                                                    <span class="text-muted">Guest Order</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    Location #{{ $order['location_id'] ?? 'N/A' }}
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $order['order_type'] ?? 'N/A' }}
                                                </span>
                                            </td>
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
                                            <td>
                                                <div class="fw-bold text-success">
                                                    ${{ number_format($order['total_amount'] ?? 0, 2) }}
                                                </div>
                                                <small class="text-muted">
                                                    Subtotal: ${{ number_format($order['subtotal'] ?? 0, 2) }}
                                                </small>
                                            </td>
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
                                            <td>
                                                <div class="small">
                                                    {{ isset($order['created_at']) ? \Carbon\Carbon::parse($order['created_at'])->format('M d, Y') : 'N/A' }}
                                                </div>
                                                <div class="small text-muted">
                                                    {{ isset($order['created_at']) ? \Carbon\Carbon::parse($order['created_at'])->format('h:i A') : '' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.orders.show', $order['order_id'] ?? 0) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(($order['order_status'] ?? 'Pending') !== 'Delivered' && ($order['order_status'] ?? 'Pending') !== 'Cancelled')
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-success" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#statusModal"
                                                                data-order-id="{{ $order['order_id'] ?? 0 }}"
                                                                data-current-status="{{ $order['order_status'] ?? 'Pending' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Orders Found</h4>
                            <p class="text-muted mb-4">Orders will appear here once customers start placing them.</p>
                        </div>
                    @endif
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
            <form id="statusForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">New Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Pending">Pending</option>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Preparing">Preparing</option>
                            <option value="Ready">Ready</option>
                            <option value="Out for Delivery">Out for Delivery</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusModal = document.getElementById('statusModal');
    const statusForm = document.getElementById('statusForm');
    const statusSelect = document.getElementById('status');
    
    statusModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const orderId = button.getAttribute('data-order-id');
        const currentStatus = button.getAttribute('data-current-status');
        
        statusForm.action = `/admin/orders/${orderId}/status`;
        statusSelect.value = currentStatus;
    });
});
</script>
@endsection 