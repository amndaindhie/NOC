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
<div style="display: none;">
    @include('frontend.settings.styles')
</div>


@endsection
