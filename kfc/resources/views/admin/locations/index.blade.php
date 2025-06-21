@extends('layouts.app')

@section('title', 'Locations - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                        Store Locations
                    </h2>
                    <p class="text-muted mb-0">Manage KFC store locations</p>
                </div>
                <a href="{{ route('admin.locations.create') }}" class="btn btn-kfc">
                    <i class="fas fa-plus me-2"></i>Add New Location
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
                    @if(count($locations) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Store Name</th>
                                        <th>Address</th>
                                        <th>City & State</th>
                                        <th>Phone</th>
                                        <th>Manager</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($locations as $location)
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">#{{ $location['location_id'] ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $location['store_name'] ?? 'N/A' }}</div>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $location['address'] ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <div>{{ $location['city'] ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $location['state'] ?? 'N/A' }} {{ $location['zip_code'] ?? '' }}</small>
                                            </td>
                                            <td>
                                                <i class="fas fa-phone text-muted me-1"></i>
                                                {{ $location['phone'] ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <i class="fas fa-user text-muted me-1"></i>
                                                {{ $location['manager_name'] ?? 'N/A' }}
                                            </td>
                                            <td>
                                                @if(($location['is_active'] ?? true))
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.locations.edit', $location['location_id'] ?? 0) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" 
                                                          action="{{ route('admin.locations.destroy', $location['location_id'] ?? 0) }}" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this location?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Locations Found</h4>
                            <p class="text-muted mb-4">Start by adding your first KFC store location.</p>
                            <a href="{{ route('admin.locations.create') }}" class="btn btn-kfc">
                                <i class="fas fa-plus me-2"></i>Add First Location
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 