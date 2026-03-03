<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
   public function index(Request $request)
{
    $query = Book::with('category');

    // Search (title, author, isbn)
    if ($request->search) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('author', 'like', "%$search%")
              ->orWhere('isbn', 'like', "%$search%");
        });
    }

    // Filter category
    if ($request->category) {
        $query->where('category_id', $request->category);
    }

    // Filter status
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // Pagination (keep search & filter)
    $books = $query->latest()->paginate(10)->appends($request->all());

    $categories = Category::all();

    return view('admin.books.index', compact('books', 'categories'));
}



    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
            'tahun_terbit' => 'nullable|string',
            'penerbit' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books', 'public');
        }

        $validated['status'] = $validated['stock'] > 0 ? 'available' : 'out_of_stock';

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book created successfully!');
    }

    public function edit(Book $book)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sinopsis' => 'nullable|string',
            'tahun_terbit' => 'nullable|string',
            'penerbit' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books', 'public');
        }

        $validated['status'] = $validated['stock'] > 0 ? 'available' : 'out_of_stock';

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        if ($book->image) {
            \Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully!');
    }
}