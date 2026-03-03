<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        $recentOrders = Order::with(['user', 'items.book']) // Ubah dari orderItems menjadi items
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'recentOrders'
        ));
    }
}