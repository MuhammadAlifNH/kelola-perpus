@extends('layouts.app')

@section('content')
<div class="mt-4">
    <h2>Daftar Buku Perpustakaan</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $book->judul }}</td>
                <td>{{ $book->penulis }}</td>
                <td>{{ $book->tahun_terbit }}</td>
                <td>
                    @if($book->stok > 0)
                        <span class="badge bg-success">Tersedia</span>
                    @else
                        <span class="badge bg-danger">Habis</span>
                    @endif
                </td>
                <td>
                    @auth
                        @if(Auth::user()->role === 'user' && $book->stok > 0)
                            <form action="{{ route('user.borrow', $book->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Pinjam</button>
                            </form>
                        @endif
                    @endauth
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data buku.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 