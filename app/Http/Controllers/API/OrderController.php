<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 🔹 Ambil semua order
    public function index()
    {
        return response()->json(Order::with(['items.menu', 'table', 'user'])->get());
    }

    // 🔹 Buat pesanan baru
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:dine-in,take-away',
            'table_id' => 'nullable|exists:tables,id',
            'items' => 'required|array',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-' . time(),
            'user_id' => Auth::id(),
            'table_id' => $request->type === 'dine-in' ? $request->table_id : null,
            'type' => $request->type,
            'status' => 'new',
            'total_price' => 0,
        ]);

        $total = 0;
        foreach ($request->items as $item) {
            $menu = Menu::find($item['menu_id']);
            $price = $menu->price * $item['quantity'];
            $total += $price;

            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $price,
            ]);
        }

        $order->update(['total_price' => $total]);

        return response()->json([
            'message' => 'Order berhasil dibuat',
            'order' => $order->load(['items.menu', 'table']),
        ], 201);
    }

    // 🔹 Detail order
    public function show($id)
    {
        $order = Order::with(['items.menu', 'table', 'user'])->findOrFail($id);
        return response()->json($order);
    }

    // 🔹 Update status order
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,cooking,ready,payment,done',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json(['message' => 'Status order diperbarui', 'order' => $order]);
    }

    // 🔹 Hapus order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Order dihapus']);
    }

    // 🔹 Order aktif
    public function active()
    {
        return response()->json(Order::where('status', '!=', 'done')->with('items.menu')->get());
    }

    // 🔹 Riwayat order
    public function history()
    {
        return response()->json(Order::where('status', 'done')->with('items.menu')->get());
    }

    // 🔹 Dashboard ringkasan
    public function dashboard()
    {
        return response()->json([
            'total_orders' => Order::count(),
            'active_orders' => Order::where('status', '!=', 'done')->count(),
            'completed_orders' => Order::where('status', 'done')->count(),
            'total_sales' => Order::sum('total_price'),
        ]);
    }
}
