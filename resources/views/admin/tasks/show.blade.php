@extends('layouts.app')

@section('title', $task->title)

@section('page-title', 'Task Detail')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}">Tasks</a></li>
    <li class="breadcrumb-item active">{{ $task->title }}</li>
@endsection

@section('page-actions')
    <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
@endsection

@section('content')

<div class="d-flex align-items-center gap-2 mb-4 flex-wrap">
    <h4 class="mb-0 fw-bold">{{ $task->title }}</h4>
    <span class="badge {{ $task->statusBadgeClass() }} fs-6">
        {{ \App\Models\Task::STATUSES[$task->status] }}
    </span>
    <span class="badge {{ $task->priorityBadgeClass() }} fs-6">
        {{ ucfirst($task->priority) }} Priority
    </span>
</div>

<div class="row g-4">

    {{-- Task Info --}}
    <div class="col-md-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-card-text me-1"></i> Task Details
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>Project:</strong>
                    <a href="{{ route('admin.projects.show', $task->project) }}" class="text-decoration-none">
                        {{ $task->project->name }}
                    </a>
                </p>
                <p class="mb-2">
                    <strong>Assigned To:</strong> {{ $task->assignedTo->name ?? '—' }}
                    @if($task->assignedTo)
                        <small class="text-muted">({{ $task->assignedTo->email }})</small>
                    @endif
                </p>
                <p class="mb-2">
                    <strong>Created By:</strong> {{ $task->createdBy->name ?? '—' }}
                </p>
                <p class="mb-2">
                    <strong>Due Date:</strong>
                    @if($task->due_date)
                        <span class="{{ $task->due_date->isPast() && $task->status !== 'done' ? 'text-danger fw-semibold' : '' }}">
                            {{ $task->due_date->format('F d, Y') }}
                            @if($task->due_date->isPast() && $task->status !== 'done')
                                <span class="badge bg-danger ms-1">Overdue</span>
                            @endif
                        </span>
                    @else
                        <span class="text-muted">No due date</span>
                    @endif
                </p>
                @if($task->description)
                    <hr>
                    <p class="text-muted mb-0">{{ $task->description }}</p>
                @endif
            </div>
            <div class="card-footer bg-white d-flex gap-2">
                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST"
                      onsubmit="return confirm('Delete this task?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Metadata --}}
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-info-circle me-1"></i> Metadata
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>Created:</strong>
                    {{ $task->created_at->format('M d, Y H:i') }}
                </p>
                <p class="mb-0">
                    <strong>Last Updated:</strong>
                    {{ $task->updated_at->format('M d, Y H:i') }}
                </p>
            </div>
        </div>
    </div>

</div>

{{-- Status Updates Log --}}
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-chat-left-text me-1"></i>
            Progress Updates ({{ $task->statusUpdates->count() }})
        </h6>
    </div>

    {{-- Existing Updates --}}
    <div class="card-body p-0">
        @forelse($task->statusUpdates->sortByDesc('created_at') as $update)
            <div class="d-flex gap-3 px-4 py-3 border-bottom">
                <div class="flex-shrink-0">
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                         style="width:38px; height:38px; font-size:0.85rem; font-weight:600;">
                        {{ strtoupper(substr($update->user->name, 0, 1)) }}
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="fw-semibold">{{ $update->user->name }}</span>
                            <span class="text-muted small ms-2">
                                {{ $update->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <form action="{{ route('admin.status-updates.destroy', [$task, $update]) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this update?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-link text-danger p-0"
                                    title="Delete update">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </form>
                    </div>
                    <p class="mb-0 mt-1">{{ $update->content }}</p>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                No updates yet. Post the first one below.
            </div>
        @endforelse
    </div>

    {{-- Post New Update Form --}}
    <div class="card-footer bg-light">
        <form action="{{ route('admin.status-updates.store', $task) }}" method="POST">
            @csrf

            <div class="mb-2">
                <label for="content" class="form-label fw-semibold">Post an Update</label>
                <textarea name="content" id="content" rows="3"
                          class="form-control @error('content') is-invalid @enderror"
                          placeholder="Describe progress, blockers, or next steps...">{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

                        <button type="submit" class="btn btn-primary">
                <i class="bi bi-send me-1"></i> Post Update
            </button>
        </form>
    </div>
</div>

@endsection