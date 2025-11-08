
@extends('layouts.main')
@section('page-title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="stats-number">{{ $categoryCount }}</div>
            <div class="stats-label">Total Categories</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-number">{{ $accountCount }}</div>
            <div class="stats-label">Total Accounts</div>
        </div>
    </div>
</div>
@endsection