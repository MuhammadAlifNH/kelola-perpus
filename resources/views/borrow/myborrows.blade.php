@extends('layouts.app')

@section('content')
<div class="mt-4">
    <h2>Buku yang Saya Pinjam</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrows as $log)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $log->book->judul ?? '-' }}</td>
                <td>{{ $log->borrow_date }}</td>
                <td>
                    @if($log->return_date)
                        <span class="badge bg-success">Dikembalikan</span>
                    @else
                        <span class="badge bg-warning">Dipinjam</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 