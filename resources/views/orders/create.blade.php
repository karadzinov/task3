@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Order</h1>
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <!-- Customer Dropdown -->
            <label for="customer_id">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>

            <!-- Order Status -->
            <label for="status">Order Status</label>
            <select name="status" id="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>

            <!-- Products to add to order -->
            <label for="products">Products</label>
            <select name="products[]" id="products" class="form-control" multiple>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} - ${{ $product->price }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Create Order</button>
        </form>

    </div>
@endsection
