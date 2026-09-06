@extends('layouts.app')

@section('title', 'Projects')

@section('page-title', 'Projects')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Projects</li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> New Project
    </a>
@endsection

@section('content')

{{-- Search & Filter --}}
<form method="GET" action="{{ route('admin.projects.index') }}" class="row g-2 mb-4">
    <div class="col-md-5">
        <input type="text" name="search" class="form-control"
               placeholder="Search by name..." value="{{ request('search') }}">
    </div>
    <div class="col-md-4">
        <select name="status" class="form-select">
            <option value="">All Statuses</option>
            @foreach($statuses as $key => $label)
                <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-outline-primary w-100">
            <i class="bi bi-search me-1"></i> Filter
        </button>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Clear</a>
    </div>
</form>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold">All Projects</h6>
        <span class="badge bg-secondary">{{ $projects->total() }} total</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Manager</th>
                        <th>Due Date</th>
                        <th>Tasks</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                    <tr>
                        <td class="fw-semibold">{{ $project->name }}</td>
                        <td>
                            <span class="badge {{ $project->statusBadgeClass() }}">
                                {{ \App\Models\Project::STATUSES[$project->status] }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $project->manager->name }}</td>
                        <td>
                            @if($project->due_date)
                                <span class="{{ $project->due_date->isPast() ? 'text-danger fw-semibold' : 'text-muted' }}">
                                    {{ $project->due_date->format('M d, Y') }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $project->tasks_count ?? 0 }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.projects.show', $project) }}"
                               class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}"
                               class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete project &quot;{{ $project->name }}&quot;?')">
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
                            <i class="bi bi-kanban fs-1 d-block mb-2"></i>
                            No projects found. <a href="{{ route('admin.projects.create') }}">Create one</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($projects->hasPages())
    <div class="card-footer bg-white d-flex justify-content-end">
        {{ $projects->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection 