@extends('layouts.app')

@section('title', 'Tasks')

@section('page-title', 'Tasks')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Tasks</li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i> New Task
    </a>
@endsection

@section('content')

{{-- Filters --}}
<form method="GET" action="{{ route('admin.tasks.index') }}" class="row g-2 mb-4">
    <div class="col-md-3">
        <select name="project_id" class="form-select">
            <option value="">All Projects</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}"
                    {{ request('project_id') == $project->id ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">All Statuses</option>
            @foreach($statuses as $key => $label)
                <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="priority" class="form-select">
            <option value="">All Priorities</option>
            @foreach($priorities as $key => $label)
                <option value="{{ $key }}" {{ request('priority') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="assigned_to" class="form-select">
            <option value="">All Assignees</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}"
                    {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-outline-primary w-100">
            <i class="bi bi-search me-1"></i> Filter
        </button>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary">Clear</a>
    </div>
</form>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-semibold">All Tasks</h6>
        <span class="badge bg-secondary">{{ $tasks->total() }} total</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td class="fw-semibold">{{ $task->title }}</td>
                        <td>
                            <a href="{{ route('admin.projects.show', $task->project) }}"
                               class="text-decoration-none text-muted small">
                                {{ $task->project->name }}
                            </a>
                        </td>
                        <td>
                            <span class="badge {{ $task->priorityBadgeClass() }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $task->statusBadgeClass() }}">
                                {{ \App\Models\Task::STATUSES[$task->status] }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $task->assignedTo->name ?? '—' }}</td>
                        <td>
                            @if($task->due_date)
                                <span class="{{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-danger fw-semibold' : 'text-muted' }}">
                                    {{ $task->due_date->format('M d, Y') }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.tasks.show', $task) }}"
                               class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.tasks.edit', $task) }}"
                               class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.tasks.destroy', $task) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this task?')">
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
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-check2-square fs-1 d-block mb-2"></i>
                            No tasks found. <a href="{{ route('admin.tasks.create') }}">Add the first one</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($tasks->hasPages())
    <div class="card-footer bg-white d-flex justify-content-end">
        {{ $tasks->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection