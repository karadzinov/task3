@extends('layouts.app')

@section('content')
    <h1>Order Details</h1>

    <div class="card">
        <div class="card-header">
            Order ID: {{ $order->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Customer: {{ $order->customer_name }}</h5>
            <p class="card-text">Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
            <p class="card-text">Items Count: {{ $order->items_count }}</p>
            <p class="card-text">Order Status: {{ ucfirst($order->status) }}</p>

            <h5 class="mt-4">Items:</h5>
            <ul>
                @foreach ($order->items as $item)
                    <li>{{ $item->product->name }} - Quantity: {{ $item->quantity }} - Price: ${{ number_format($item->price, 2) }}</li>
                @endforeach
            </ul>

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
        </div>
    </div>
@endsection
