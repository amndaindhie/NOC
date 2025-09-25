@extends('frontend.layout')

@php
$hide_footer = true;
$hide_navbar = true;
@endphp

@section('content')
@if(Auth::user()->hasRole('admin'))
    @include('layouts.partials.sidebar')
@else
    @include('layouts.partials.sidebar_profile')
@endif



<div class="main-content">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h2 class="card-title mb-0">⚙️ Settings</h2>
        </div>
        <div class="card-body">
            <!-- Combined Profile Settings Form -->
            <div class="form-container">
                <livewire:profile.update-profile-settings-form />
            </div>
        </div>
        </div>
    </div>
</div>

<style>
.main-content {
    margin-left: 78px;
    transition: all 0.5s ease;
    padding: 2rem;
    background-color: #f8f9fa;
    min-height: 100vh;
}

/* saat sidebar terbuka */
.sidebar.open ~ .main-content {
    margin-left: 250px;
}

/* Card title */
.card-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #11101D;
}

/* ===== Form Styling ===== */
.form-container {
    max-width: 700px;
}

.form-container form {
    background: #fff;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.form-container label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
    color: #11101D;
}

.form-container .form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 0.6rem 0.75rem;
    transition: all 0.2s ease;
}

.form-container .form-control:focus {
    border-color: #11101D;
    box-shadow: 0 0 0 0.2rem rgba(17,16,29,0.1);
}

.form-container .form-text {
    font-size: 0.85rem;
    color: #6c757d;
}

.form-container button[type="submit"],
.form-container .btn-primary {
    background-color: #11101D;
    border: none;
    border-radius: 8px;
    padding: 0.6rem 1.2rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.form-container button[type="submit"]:hover,
.form-container .btn-primary:hover {
    background-color: #343a40;
}
</style>


@endsection
