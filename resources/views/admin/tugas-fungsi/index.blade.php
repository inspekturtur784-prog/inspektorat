@extends('admin.layout')
@section('title', 'Kelola Tugas & Fungsi')

@section('content')
<div class="admin-header">
    <h1>Kartu Fungsi</h1>
    <a href="{{ route('admin.tugasfungsi.create') }}" class="btn-admin btn-admin-primary">+ Tambah Kartu</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Urutan</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Ikon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $item)
            <tr>
                <td>{{ $item->urutan }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ Str::limit($item->deskripsi, 60) }}</td>
                <td>{{ \App\Models\TugasFungsi::IKON[$item->icon] ?? $item->icon }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.tugasfungsi.edit', $item) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.tugasfungsi.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus kartu ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada kartu Fungsi. Klik "Tambah Kartu" untuk membuat yang pertama.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection