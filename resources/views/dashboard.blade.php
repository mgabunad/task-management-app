@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm rounded-3">
        <div class="p-4 text-dark">
            <h3 class="fw-bold">
                Hello, {{ Auth::user()->name }}! 🎉
            </h3>
            <p class="mt-2 text-secondary">
                You are logged in and have access to your secure dashboard.
            </p>
        </div>
    </div>
@endsection