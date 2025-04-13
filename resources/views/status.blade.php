@extends('layouts.app')
@section('content')
<div class="container">
    <h2 class="order-title">Your Order Status</h2>
    
    @forelse($orders as $order)
        <div class="order-item">
            <div class="order-content">
                <div class="order-row">
                    <div class="order-label">Order ID:</div>
                    <div class="order-value">{{ $order->id }}</div>
                </div>
                <div class="order-row">
                    <div class="order-label">Date:</div>
                    <div class="order-value">{{ $order->order_date }}</div>
                </div>
                <div class="order-row">
                    <div class="order-label">Total:</div>
                    <div class="order-value">RM {{ number_format($order->total_amount, 2) }}</div>
                </div>
                <div class="order-row">
                    <div class="order-label">Status:</div>
                    <div class="order-value status-badge status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</div>
                </div>
            </div>
        </div>
    @empty
        <div class="no-orders">
            <p>No orders found.</p>
        </div>
    @endforelse
    
    <div class="action-area">
        <a href="{{ route('profile') }}" class="btn-cancel">Back to Profile</a>
    </div>
</div>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .order-title {
        color: #333;
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
    }
    
    .order-title:after {
        content: '';
        position: absolute;
        width: 60px;
        height: 3px;
        background: #4a90e2;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }
    
    .order-item {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .order-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .order-content {
        padding: 20px;
    }
    
    .order-row {
        display: flex;
        margin-bottom: 12px;
        align-items: center;
    }
    
    .order-row:last-child {
        margin-bottom: 0;
    }
    
    .order-label {
        font-weight: 600;
        color: #555;
        width: 80px;
        flex-shrink: 0;
    }
    
    .order-value {
        color: #333;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .status-completed {
        background-color: #e3f8e3;
        color: #1e7e1e;
    }
    
    .status-processing {
        background-color: #fff4de;
        color: #956a15;
    }
    
    .status-pending {
        background-color: #e6f0ff;
        color: #1a5bb5;
    }
    
    .status-cancelled {
        background-color: #ffe6e6;
        color: #c93030;
    }
    
    .no-orders {
        text-align: center;
        background: #f9f9f9;
        padding: 40px;
        border-radius: 8px;
        color: #777;
        font-style: italic;
    }
    
    .action-area {
        text-align: center;
        margin-top: 25px;
    }
    
    .btn-cancel {
        display: inline-block;
        background: #5a6268;
        color: white;
        padding: 10px 24px;
        border-radius: 4px;
        text-decoration: none;
        transition: background 0.2s;
        font-weight: 500;
    }
    
    .btn-cancel:hover {
        background: #4a545b;