@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold">Order History</h2>
    
    @forelse($orders as $order)
        <div class="order-card mb-3 shadow-sm rounded">
            <div class="order-header d-flex justify-content-between align-items-center">
                <span class="order-id">Order #{{ $order->id }}</span>
                <span class="order-status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="order-body">
                <div class="order-detail">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ $order->order_date }}</span>
                </div>
                <div class="order-detail">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>RM {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state text-center p-5">
            <i class="fas fa-shopping-bag empty-icon"></i>
            <p class="mt-3">No completed orders yet.</p>
        </div>
    @endforelse
    
    <div class="text-center mt-4">
        <a href="{{ route('profile') }}" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<style>
    .order-card {
        border: none;
        background-color: #fff;
        transition: transform 0.2s;
        overflow: hidden;
    }
    
    .order-card:hover {
        transform: translateY(-3px);
    }
    
    .order-header {
        background-color: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }
    
    .order-id {
        font-weight: 600;
        color: #333;
    }
    
    .order-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .order-status.completed {
        background-color: #d4edda;
        color: #155724;
    }
    
    .order-status.processing {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .order-status.pending {
        background-color: #cce5ff;
        color: #004085;
    }
    
    .order-status.cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .order-body {
        padding: 20px;
    }
    
    .order-detail {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .order-detail:last-child {
        margin-bottom: 0;
    }
    
    .order-detail i {
        color: #6c757d;
        margin-right: 10px;
        width: 18px;
    }
    
    .empty-state {
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .empty-icon {
        font-size: 3rem;
        color: #adb5bd;
    }
    
    .btn-back {
        background-color: #6c757d;
        color: white;
        padding: 8px 20px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }
    
    .btn-back:hover {
        background-color: #5a6268;
        color: white;
        text-decoration: none;
    }
    
    h2 {
        color: #343a40;
        margin-bottom: 30px;
    }
</style>
@endsection