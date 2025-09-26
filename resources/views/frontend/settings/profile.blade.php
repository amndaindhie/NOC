@extends('frontend.layout')

@php
$hide_footer = true;
$hide_navbar = true;
@endphp

@section('content')
@php
$sidebar_open = true;
@endphp
@if(Auth::user()->hasRole('admin'))
    @include('layouts.partials.sidebar')
@else
    @include('layouts.partials.sidebar_profile')
@endif

<div class="main-content">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h2 class="card-title mb-0">⚙️ Profile</h2>
        </div>
        <div class="card-body">
            <div class="form-container">
                <livewire:profile.profil-informasi />
            </div>
        </div>
    </div>
</div>

<div style="display: none;">
    @include('frontend.settings.styles')
</div>
@endsection
