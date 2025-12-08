@extends('frontend.layout')

@php
$hide_footer = true;
$hide_navbar = true;
@endphp

@section('content')
@php
$sidebar_open = true;
@endphp
    @include('layouts.partials.sidebar_profile')

<div class="main-content">
    <div class="border-0 shadow-sm card">
        <div class="bg-white border-0 card-header">
            <h2 class="mb-0 card-title">⚙️ Profile</h2>
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
