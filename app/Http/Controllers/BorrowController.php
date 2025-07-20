<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BorrowLog;

class BorrowController extends Controller
{
    public function create()
    {
        $books = Book::where('stok', '>', 0)->get();
        return view('borrow.create', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'borrower_name' => 'required|string|max:255',
            'book_id' => 'required|exists:books,id',
        ]);
        $book = Book::findOrFail($validated['book_id']);
        if ($book->stok < 1) {
            return back()->withErrors(['book_id' => 'Stok buku habis!']);
        }
        BorrowLog::create([
            'book_id' => $validated['book_id'],
            'borrower_name' => $validated['borrower_name'],
            'borrow_date' => now(),
        ]);
        $book->decrement('stok');
        return redirect()->route('borrow.index')->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function index()
    {
        $borrowed = \App\Models\BorrowLog::with('book')->whereNull('return_date')->get();
        return view('borrow.index', compact('borrowed'));
    }

    public function update($id)
    {
        $log = \App\Models\BorrowLog::findOrFail($id);
        if ($log->return_date) {
            return back()->with('error', 'Buku sudah dikembalikan sebelumnya.');
        }
        $log->update(['return_date' => now()]);
        $log->book->increment('stok');
        return redirect()->route('borrow.index')->with('success', 'Buku berhasil dikembalikan!');
    }

    public function userBorrow($bookId)
    {
        $book = \App\Models\Book::findOrFail($bookId);
        if ($book->stok < 1) {
            return back()->with('error', 'Stok buku habis!');
        }
        \App\Models\BorrowLog::create([
            'book_id' => $book->id,
            'borrower_name' => auth()->user()->name,
            'borrow_date' => now(),
        ]);
        $book->decrement('stok');
        return back()->with('success', 'Buku berhasil dipinjam!');
    }

    public function myBorrows()
    {
        $borrows = \App\Models\BorrowLog::with('book')
            ->where('borrower_name', auth()->user()->name)
            ->orderByDesc('borrow_date')
            ->get();
        return view('borrow.myborrows', compact('borrows'));
    }

    public function manageBorrows()
    {
        $borrows = \App\Models\BorrowLog::with('book')
            ->orderByDesc('borrow_date')
            ->get();
        return view('borrow.manage', compact('borrows'));
    }
}
