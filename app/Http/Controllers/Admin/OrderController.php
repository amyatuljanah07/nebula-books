<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.book'])
            ->latest()
            ->get();
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.book']);
        return view('admin.orders.show', compact('order'));
    }

    
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status berhasil diupdate');
    }

    
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:unpaid,pending_verification,paid'
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return redirect()->back()->with('success', 'Payment status berhasil diupdate');
    }

   
    public function destroy(Order $order)
    {
        if ($order->canBeCancelled()) {
            $order->delete();
            return redirect()->route('admin.orders.index')
                ->with('success', 'Order berhasil dihapus');
        }

        return redirect()->back()
            ->with('error', 'Order tidak dapat dihapus');
    }
}