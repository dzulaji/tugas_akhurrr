<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.pages.books.index", [
            'books' => Book::all(),
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:3',
            'code' => 'required|min:5',
            'author' => 'required',
            'year' => 'required',
            'publisher' => 'required',
            'category_id' => 'required',
            'description' => 'required|min:10',
            'stock' => 'required',
            'cover' => 'image|file|max:1024',
            'pages' => 'required|integer',
            'language' => 'required',
            'isbn_issn' => 'required',
            'content_type' => 'required',
            'media_type' =>'required',
            'carrier_type' => 'required',
            'edition' => 'required',
            'subject' => 'required',
        ]);

        if (isset($validatedData['cover'])) {
            $validatedData['cover'] = $request->file('cover')->store('books-cover');
        }

        Book::create($validatedData);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('admin.pages.books.show', [
            'book' => $book,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:3',
            'code' => 'required|min:5',
            'author' => 'required',
            'year' => 'required',
            'publisher' => 'required',
            'category_id' => 'required',
            'description' => 'required|min:10',
            'stock' => 'required',
            'cover' => 'image|file|max:1024',
            'pages' => 'required|integer',
            'language' => 'required',
            'isbn_issn' => 'required',
            'content_type' => 'required',
            'media_type' => 'required',
            'carrier_type' => 'required',
            'edition' => 'required',
            'subject' => 'required',
        ]);

        if (isset($validatedData['cover'])) {
            $validatedData['cover'] = $request->file('cover')->store('books-cover');
        }

        $book->update($validatedData);

        return redirect()->back()->with('success', 'Buku berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/admin/books')->with('success', 'buku berhasil dihapus!');
    }
}
