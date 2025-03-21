@extends('layouts.app')

@section('content')
    <h1>Orders</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total Amount</th>
            <th>Items Count</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order['order_id'] }}</td>
                <td>{{ $order['customer_name'] }}</td>
                <td>{{ $order['total_amount'] }}</td>
                <td>{{ $order['items_count'] }}</td>
                <td>{{ $order['completed_order_exists'] ? 'Completed' : 'Pending' }}</td>
                <td>
                    <a href="{{ route('orders.show', $order['order_id']) }}">View</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
