<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'items.product'])
            ->get()
            ->map(function ($order) {
                $totalAmount = 0;
                $itemsCount = 0;

                foreach ($order->items as $item) {
                    $totalAmount += $item->price * $item->quantity;
                    $itemsCount++;
                }

                $lastAddedToCart = $order->items->sortByDesc('created_at')->first()->created_at ?? null;

                $completedOrderExists = $order->status === 'completed';

                return [
                    'order_id' => $order->id,
                    'customer_name' => $order->customer->name,
                    'total_amount' => $totalAmount,
                    'items_count' => $itemsCount,
                    'last_added_to_cart' => $lastAddedToCart,
                    'completed_order_exists' => $completedOrderExists,
                    'created_at' => $order->created_at,
                    'completed_at' => $order->completed_at,
                ];
            })
            ->sortByDesc('completed_at')
            ->values();

        return view('orders.index', ['orders' => $orders]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $customer = $order->customer;
        $items = $order->items;
        $totalAmount = 0;

        foreach ($items as $item) {
            $totalAmount += $item->price * $item->quantity;
        }

        return view('orders.show', compact('order', 'customer', 'items', 'totalAmount'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('orders.create', compact('customers', 'products'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|string',
            'products' => 'required|array',
            'products.*' => 'exists:products,id'
        ]);

        $order = Order::create([
            'customer_id' => $request->input('customer_id'),
            'status' => $request->input('status'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $totalAmount = 0;
        $itemsCount = 0;

        foreach ($request->input('products') as $productId) {
            $product = Product::find($productId);
            CartItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $totalAmount += $product->price;
            $itemsCount++;
        }

        $order->update([
            'total_amount' => $totalAmount,
            'items_count' => $itemsCount
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|string',
        ]);

        $order->status = $request->input('status');
        $order->updated_at = Carbon::now();
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }

}
