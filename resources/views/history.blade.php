<link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
<script src="{{ asset('js/navigation.js') }}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

@extends('layouts.app')

@section('content')
    <div class="container">
        @include('partials.navigation')

        <h2 class="mb-4 text-center fw-bold">Order History</h2>

        @php
            // Filter to only include delivered orders
            $deliveredOrders = $orders->where('status', 'delivered');
        @endphp

        @if($deliveredOrders->count() > 0)
            <div class="text-center mb-3">
                <h4 class="text-success">Completed Orders</h4>
            </div>

            @foreach($deliveredOrders as $order)
                <div class="order-card mb-3 shadow-sm rounded">
                    <div class="order-header d-flex justify-content-between align-items-center">
                        <span class="order-id">Order #{{ $order->id }}</span>
                        <span class="order-status delivered">Delivered</span>
                    </div>
                    <div class="order-body">
                        <div class="order-detail">
                            <i class="fas fa-calendar-alt"></i>
                            @php
                                $orderDate = Carbon\Carbon::parse($order->order_date)->timezone('GMT+8');
                            @endphp
                            <span>{{ "Ordered at: ".$orderDate->format('F j, Y \a\t g:i A') }}</span>
                            <i class="fas fa-check-circle text-success ms-3"></i>
                            @php
                                $deliveredDate = Carbon\Carbon::parse($order->delivered_at)->timezone('GMT+8');
                            @endphp
                            <span>Delivered at: {{$deliveredDate->format('F j, Y \a\t g:i A') }}</span>
                        </div>
                        <div class="order-detail">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>RM {{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state text-center p-5">
                <i class="fas fa-shopping-bag empty-icon"></i>
                <p class="mt-3">No completed orders yet.</p>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('profile') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <style>
        /* Order History Specific Styles */
        .order-card {
            border: none;
            background-color: #fff;
            transition: transform 0.2s, box-shadow 0.3s;
            overflow: hidden;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .order-header {
            background-color: #f8f9fa;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-id {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
        }

        .order-status {
            padding: 0.35rem 1rem;
            border-radius: 2rem;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .order-status.delivered {
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
            padding: 1.25rem;
        }

        .order-detail {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
            color: #495057;
        }

        .order-detail:last-child {
            margin-bottom: 0;
        }

        .order-detail i {
            color: #6c757d;
            margin-right: 0.625rem;
            width: 1.125rem;
            text-align: center;
        }

        .empty-state {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .empty-icon {
            font-size: 3.5rem;
            color: #adb5bd;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* Button Styles */
        .btn-back {
            background-color: #6c757d;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: white;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }

        .btn-back i {
            font-size: 0.9rem;
        }

        /* Title Styles */
        h2.mb-4 {
            color: #343a40;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        h2.mb-4:after {
            content: '';
            position: absolute;
            width: 4rem;
            height: 0.25rem;
            background: #6c757d;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 0.125rem;
        }

        h4.text-success {
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 767.98px) {
            .order-detail {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .order-detail i.ms-3 {
                margin-left: 0 !important;
                margin-top: 0.5rem;
            }

            .order-header {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
        }
    </style>
@endsection