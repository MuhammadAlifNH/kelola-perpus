@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Buku yang Dipinjam</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Nama Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowed as $log)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $log->book->judul ?? '-' }}</td>
                <td>{{ $log->borrower_name }}</td>
                <td>{{ $log->borrow_date }}</td>
                <td>
                    <form action="{{ route('borrow.return', $log->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin mengembalikan buku ini?')">Kembalikan</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada buku yang sedang dipinjam.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Kembali ke Daftar Buku</a>
</div>
@endsection 