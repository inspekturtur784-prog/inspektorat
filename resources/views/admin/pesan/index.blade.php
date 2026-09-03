@extends('admin.layout')
@section('title', 'Pesan Masuk')

@section('content')
<div class="admin-header">
    <h1>Pesan Masuk</h1>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Status</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pesans as $pesan)
            <tr>
                <td>
                    @if ($pesan->is_read)
                        <span class="badge badge-off">Sudah dibaca</span>
                    @else
                        <span class="badge badge-on">Baru</span>
                    @endif
                </td>
                <td>{{ $pesan->nama }}</td>
                <td>{{ $pesan->email }}</td>
                <td>{{ $pesan->created_at->format('d/m/Y H:i') }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.pesan.show', $pesan) }}" class="btn-admin btn-admin-ghost">Baca</a>
                    <form action="{{ route('admin.pesan.destroy', $pesan) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada pesan masuk.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:20px;">{{ $pesans->links() }}</div>
@endsection