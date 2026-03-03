<?php


namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Get featured books with category relationship
        $featuredBooks = Book::with('category')
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('landing', compact('featuredBooks'));
    }
}