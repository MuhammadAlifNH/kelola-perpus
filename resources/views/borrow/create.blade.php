@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Form Peminjaman Buku</h2>
    <form action="{{ route('borrow.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="borrower_name" class="form-label">Nama Peminjam</label>
            <input type="text" class="form-control" id="borrower_name" name="borrower_name" required>
        </div>
        <div class="mb-3">
            <label for="book_id" class="form-label">Pilih Buku</label>
            <select class="form-control" id="book_id" name="book_id" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}">{{ $book->judul }} (Stok: {{ $book->stok }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Pinjam</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection 