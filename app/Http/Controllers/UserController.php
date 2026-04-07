<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $totalBooks = Book::where('status', 'available')->count();
        $totalOrders = Order::where('user_id', $user->id)->count();
        $cartItems = Cart::where('user_id', $user->id)->sum('quantity');
        $totalSpent = Order::where('user_id', $user->id)
                           ->where('status', 'completed')
                           ->sum('total_amount');
        
        $recentOrders = Order::where('user_id', $user->id)
                             ->with('items.book')
                             ->orderBy('created_at', 'desc')
                             ->take(5)
                             ->get();
        
        return view('user.dashboard', compact(
            'totalBooks',
            'totalOrders',
            'cartItems',
            'totalSpent',
            'recentOrders'
        ));
    }

    public function books(Request $request)
    {
        $query = Book::with('category')->where('status', 'available');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }
        
    
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        
       
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'popular':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $books = $query->paginate(10)->withQueryString();
        $categories = Category::all();
        
        return view('user.books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
      
        $relatedBooks = Book::where('category_id', $book->category_id)
                           ->where('id', '!=', $book->id)
                           ->where('status', 'available')
                           ->limit(4)
                           ->get();
        
        return view('user.books.show', compact('book', 'relatedBooks'));
    }

    public function cart()
    {
        $cartItems = Cart::where('user_id', Auth::id())
                        ->with('book')
                        ->get();
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->book->price * $item->quantity;
        });
        
        return view('user.cart.index', compact('cartItems', 'subtotal'));
    }

    public function addToCart(Request $request, Book $book)
    {
      
        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku tidak tersedia!');
        }

      
        $cartItem = Cart::where('user_id', Auth::id())
                       ->where('book_id', $book->id)
                       ->first();

        if ($cartItem) {
      
            if ($cartItem->quantity >= $book->stock) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia!');
            }
            
            $cartItem->increment('quantity');
            return back()->with('success', 'Jumlah buku di keranjang berhasil ditambah!');
        } else {
         
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'quantity' => 1
            ]);
            
            return back()->with('success', 'Buku berhasil ditambahkan ke keranjang!');
        }
    }

    public function updateCart(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

       
        if ($cart->user_id != Auth::id()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized action!']);
            }
            return back()->with('error', 'Unauthorized action!');
        }

       
        if ($request->quantity > $cart->book->stock) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Jumlah melebihi stok yang tersedia!']);
            }
            return back()->with('error', 'Jumlah melebihi stok yang tersedia!');
        }

        $cart->update(['quantity' => $request->quantity]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Keranjang berhasil diupdate!']);
        }
        
        return back()->with('success', 'Keranjang berhasil diupdate!');
    }

    public function removeFromCart(Cart $cart)
    {
        
        if ($cart->user_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action!');
        }

        $cart->delete();
        
        return back()->with('success', 'Buku berhasil dihapus dari keranjang!');
    }

    public function showCheckout()
    {
        $user = Auth::user();
        $selectedIds = session('checkout_selected_items', []);
        

        if (empty($selectedIds)) {
            return redirect()->route('user.cart.index')->with('info', 'Pilih item dari keranjang terlebih dahulu!');
        }

        $cartItems = Cart::where('user_id', Auth::id())
                        ->whereIn('id', $selectedIds)
                        ->with('book')
                        ->get();
        
        if ($cartItems->count() == 0) {
            return redirect()->route('user.cart.index')->with('error', 'Item yang dipilih tidak ditemukan!');
        }
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->book->price * $item->quantity;
        });

        $lastOrder = Order::where('user_id', $user->id)->latest()->first();
        
        return view('user.checkout.index', compact('cartItems', 'subtotal', 'user', 'lastOrder'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'selected_items' => 'required|array|min:1',
            'selected_items.*' => 'integer|exists:cart,id',
        ]);

        $selectedIds = $request->input('selected_items', []);

        $cartItems = Cart::where('user_id', Auth::id())
                        ->whereIn('id', $selectedIds)
                        ->with('book')
                        ->get();
        
        if ($cartItems->count() == 0) {
            return redirect()->route('user.cart.index')->with('error', 'Pilih minimal 1 item untuk checkout!');
        }
        
        $subtotal = $cartItems->sum(function($item) {
            return $item->book->price * $item->quantity;
        });

        session(['checkout_selected_items' => $selectedIds]);

        $user = Auth::user();
        $lastOrder = Order::where('user_id', $user->id)->latest()->first();
        
        return view('user.checkout.index', compact('cartItems', 'subtotal', 'user', 'lastOrder'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:bca,mandiri,bni,bri,gopay,ovo,dana,shopeepay',
        ]);

       
        $selectedIds = session('checkout_selected_items', []);

        $cartItems = Cart::where('user_id', Auth::id())
                        ->whereIn('id', $selectedIds)
                        ->with('book')
                        ->get();

        if ($cartItems->count() == 0) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang Anda kosong atau item sudah tidak tersedia!');
        }

  
        $subtotal = $cartItems->sum(function($item) {
            return $item->book->price * $item->quantity;
        });
        $adminFee = 5000;
        $total = $subtotal + $adminFee;

    
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
            'total_amount' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => $request->payment_method,
            'payment_deadline' => now()->addHours(24),
            'shipping_address' => $request->shipping_address . ', ' . $request->city . ' ' . $request->postal_code,
            'phone' => $request->phone,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'notes' => $request->notes,
        ]);

      
        foreach ($cartItems as $item) {
            $order->items()->create([
                'book_id' => $item->book_id,
                'quantity' => $item->quantity,
                'price' => $item->book->price,
                'subtotal' => $item->book->price * $item->quantity,
            ]);

       
            $item->book->decrement('stock', $item->quantity);
        }

        Cart::where('user_id', Auth::id())
            ->whereIn('id', $selectedIds)
            ->delete();

  
        session()->forget('checkout_selected_items');

        return redirect()->route('user.payment', $order)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

     public function payment(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized action!');
        }

        return view('user.payment.index', compact('order'));
    }

    public function uploadPaymentProof(Request $request, Order $order)
    {
        if ($order->user_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action!');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $order->update([
                'payment_proof' => $path,
                'payment_status' => 'pending_verification'
            ]);
        }

        return redirect()->route('user.dashboard')->with('success', 'Bukti pembayaran berhasil diupload! Pesanan Anda sedang diverifikasi oleh admin.');
    }

     public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->with('items.book')
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        
        return view('user.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
      
        if ($order->user_id != Auth::id()) {
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized action!');
        }

        $order->load('items.book');
        
        return view('user.orders.show', compact('order'));
    }
}