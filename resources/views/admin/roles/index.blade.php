@extends('layouts.app')

@section('title', 'Roles Management')

@section('page-title', 'Roles Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> Add Role
    </a>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold">All Roles</h6>
        <span class="badge bg-secondary">{{ $roles->total() }} total</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Users</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td class="text-muted small">{{ $role->id }}</td>
                        <td>
                            <span class="badge bg-secondary text-uppercase">
                                {{ $role->name }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $role->description ?? '—' }}</td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $role->users_count }} user(s)
                            </span>
                        </td>
                        <td class="text-muted small">{{ $role->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.roles.show', $role) }}"
                               class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.roles.edit', $role) }}"
                               class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.roles.destroy', $role) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this role?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-shield-lock fs-1 d-block mb-2"></i>
                            No roles found. <a href="{{ route('admin.roles.create') }}">Create one</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($roles->hasPages())
    <div class="card-footer bg-white d-flex justify-content-end">
        {{ $roles->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection