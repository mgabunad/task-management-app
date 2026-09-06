@extends('layouts.app')

@section('title', $project->name)

@section('page-title', 'Project Detail')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item active">{{ $project->name }}</li>
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
@endsection

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <h4 class="mb-0 fw-bold">{{ $project->name }}</h4>
    <span class="badge {{ $project->statusBadgeClass() }} fs-6">
        {{ \App\Models\Project::STATUSES[$project->status] }}
    </span>
</div>

{{-- Project Info --}}
<div class="card shadow-sm border-0 mb-4" style="max-width: 700px;">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-folder me-1"></i> Project Information
        </h6>
    </div>
    <div class="card-body">
        <p class="mb-2">
            <strong>Manager:</strong> {{ $project->manager->name }}
            <small class="text-muted">({{ $project->manager->email }})</small>
        </p>
        <p class="mb-2">
            <strong>Due Date:</strong>
            @if($project->due_date)
                <span class="{{ $project->due_date->isPast() && $project->status !== 'completed' ? 'text-danger fw-semibold' : '' }}">
                    {{ $project->due_date->format('F d, Y') }}
                    @if($project->due_date->isPast() && $project->status !== 'completed')
                        <span class="badge bg-danger ms-1">Overdue</span>
                    @endif
                </span>
            @else
                <span class="text-muted">No due date set</span>
            @endif
        </p>
        @if($project->description)
            <hr>
            <p class="mb-0 text-muted">{{ $project->description }}</p>
        @endif
    </div>
    <div class="card-footer bg-white d-flex gap-2">
        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
              onsubmit="return confirm('Delete this project and all its tasks?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">
                <i class="bi bi-trash me-1"></i> Delete
            </button>
        </form>
    </div>
</div>

{{-- Tasks placeholder until Part 5 --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold">
            <i class="bi bi-check2-square me-1"></i> Tasks
        </h6>
    </div>
    <div class="card-body text-center text-muted py-5">
        <i class="bi bi-hourglass-split fs-1 d-block mb-2"></i>
        Task management for this project is coming soon.
    </div>
</div>

<div class="text-muted small mt-3">
    Created: {{ $project->created_at->format('M d, Y H:i') }} &nbsp;|&nbsp;
    Updated: {{ $project->updated_at->format('M d, Y H:i') }}
</div>

@endsection