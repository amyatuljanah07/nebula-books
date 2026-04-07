<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        $featuredBooks = Book::with('category')
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $popularBookIds = DB::table('books')
            ->leftJoin('order_items', 'books.id', '=', 'order_items.book_id')
            ->select('books.id', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->where('books.stock', '>', 0)
            ->groupBy('books.id')
            ->orderByDesc('total_sold')
            ->limit(4)
            ->pluck('id')
            ->toArray();

        $popularBooks = Book::with('category')
            ->whereIn('id', $popularBookIds)
            ->get()
            ->sortBy(function ($book) use ($popularBookIds) {
                return array_search($book->id, $popularBookIds);
            })
            ->values();


        $newestBooks = Book::with('category')
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

       
        $categories = Category::where('is_active', true)->get();

        return view('landing', compact('featuredBooks', 'popularBooks', 'newestBooks', 'categories'));
    }

    
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $books = Book::with('category')
            ->where('stock', '>', 0)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('author', 'like', "%{$query}%")
                  ->orWhere('penerbit', 'like', "%{$query}%");
            })
            ->take(8)
            ->get()
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'price' => 'Rp ' . number_format($book->price, 0, ',', '.'),
                    'category' => $book->category->name ?? 'Uncategorized',
                    'image' => $book->image ? asset('storage/' . $book->image) : 'https://via.placeholder.com/60x80?text=No+Image',
                    'url' => route('books.show', $book),
                ];
            });

        return response()->json($books);
    }
}