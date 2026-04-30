<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::query()
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('books.index', [
            'books' => $books,
        ]);
    }

    public function create(): View
    {
        return view('books.create', [
            'book' => new Book(),
            'pageMode' => 'create',
            'pageTitle' => 'Tambah Buku',
        ]);
    }

    public function store(StoreBookRequest $request): RedirectResponse
    {
        $book = Book::create($request->validated());

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $book): View
    {
        return view('books.show', [
            'book' => $book,
        ]);
    }

    public function edit(Book $book): View
    {
        return view('books.edit', [
            'book' => $book,
            'pageMode' => 'edit',
            'pageTitle' => 'Ubah Buku',
        ]);
    }

    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $book->update($request->validated());

        return redirect()
            ->route('books.show', $book)
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
