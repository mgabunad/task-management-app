@extends('layouts.app')

@section('title', 'Role Detail')

@section('page-title', 'Role Detail')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active text-uppercase">{{ $role->name }}</li>
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
@endsection

@section('content')

{{-- Role Info --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold">Role Information</h6>
    </div>
    <div class="card-body">
        <p>
            <strong>Name:</strong>
            <span class="badge bg-secondary text-uppercase">{{ $role->name }}</span>
        </p>
        <p class="mb-0">
            <strong>Description:</strong> {{ $role->description ?? 'No description provided.' }}
        </p>
    </div>
</div>

{{-- Users with this role --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold">
            Users with this Role ({{ $role->users->count() }})
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Assigned On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($role->users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td class="text-muted small">{{ $user->pivot->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            No users assigned to this role yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Assign Role to a User --}}
<div class="card shadow-sm border-0" style="max-width: 500px;">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold">Assign This Role to a User</h6>
    </div>
    <div class="card-body">
        <form action="" method="POST" id="assignForm">
    @csrf
    <input type="hidden" name="roles[]" value="{{ $role->id }}">

    <div class="mb-3">
        <label for="user_id" class="form-label">Select User</label>
        <select name="user_id" id="user_id" class="form-select" required
                onchange="updateFormAction(this)">  
                    <option value="">-- Choose a user --</option>
                    @foreach($allUsers as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>

            <p class="text-muted small">
                This will assign the <strong class="text-uppercase">{{ $role->name }}</strong> role to the selected user.
                To manage multiple roles for a user at once, go to the user's detail page.
            </p>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Assign Role
            </button>
        </form>
    </div>
</div>

<script>
function updateFormAction(select) {
    const userId = select.value;
    const form = document.getElementById('assignForm');
    form.action = `/admin/users/${userId}/assign-roles`;
}
</script>
@endsection