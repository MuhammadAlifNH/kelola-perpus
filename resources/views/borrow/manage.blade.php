@extends('layouts.app')

@section('content')
<div class="mt-4">
    <h2>Kelola Peminjaman Buku</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Nama Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrows as $log)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $log->book->judul ?? '-' }}</td>
                <td>{{ $log->borrower_name }}</td>
                <td>{{ $log->borrow_date }}</td>
                <td>
                    @if($log->return_date)
                        <span class="badge bg-success">Dikembalikan</span>
                    @else
                        <span class="badge bg-warning">Dipinjam</span>
                    @endif
                </td>
                <td>
                    @if(!$log->return_date)
                        <form action="{{ route('borrow.return', $log->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi buku sudah dikembalikan?')">Konfirmasi Kembali</button>
                        </form>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada transaksi peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 