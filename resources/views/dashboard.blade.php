
@extends('layouts.main')
@section('page-title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="stats-number">{{ $categoryCount }}</div>
            <div class="stats-label">Total Categories</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="stats-number">{{ $userCount }}</div>
            <div class="stats-label">Total Users</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stats-number">{{ $accountCount }}</div>
            <div class="stats-label">Total Accounts</div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Categories</h5>
            </div>
            <div class="card-body">
                @if($categories->count() > 0)
                    <div class="list-group">
                        @foreach($categories as $category)
                            <a href="#" class="list-group-item list-group-item-action"  data-ajax-popup="true" data-size="lg"
                             data-title="{{ __('Users in') }} {{ $category->name }}" data-url="{{ route('dashboard.category.accounts',$category->id) }}"
                             data-bs-toggle="tooltip" data-bs-original-title="{{ __('Create') }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No categories found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection