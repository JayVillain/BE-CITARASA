<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.menu', 'table', 'user'])->get();
        return response()->json($orders, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:dine-in,take-away',
            'table_id' => 'nullable|exists:tables,id',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(6)),
            'user_id' => auth()->id(),
            'table_id' => $request->table_id,
            'type' => $request->type,
            'total_price' => 0,
            'status' => 'new'
        ]);

        $total = 0;
        foreach ($request->items as $item) {
            $price = \App\Models\Menu::find($item['menu_id'])->price;
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'quantity' => $item['quantity'],
                'price' => $price
            ]);
            $total += $price * $item['quantity'];
        }

        $order->update(['total_price' => $total]);

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'data' => $order->load('items.menu')
        ], 201);
    }

    public function show($id)
    {
        $order = Order::with(['items.menu', 'table', 'user'])->findOrFail($id);
        return response()->json($order, 200);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'in:new,cooking,ready,payment,done'
        ]);

        $order->update($request->only('status'));

        return response()->json([
            'message' => 'Status pesanan diperbarui',
            'data' => $order
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Pesanan dibatalkan'], 200);
    }

    public function active()
    {
        $orders = Order::whereIn('status', ['new','cooking','ready','payment'])
                       ->with('items.menu')
                       ->get();
        return response()->json($orders, 200);
    }

    public function history()
    {
        $orders = Order::where('status', 'done')
                       ->with('items.menu')
                       ->get();
        return response()->json($orders, 200);
    }

    public function dashboard()
    {
        return response()->json([
            'total_orders' => Order::count(),
            'active_orders' => Order::whereIn('status', ['new','cooking','ready','payment'])->count(),
            'done_orders' => Order::where('status', 'done')->count(),
            'revenue' => Order::where('status', 'done')->sum('total_price')
        ]);
    }
}
