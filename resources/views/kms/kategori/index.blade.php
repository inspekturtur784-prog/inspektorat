@extends('admin.layout')
@section('title', 'KMS / Pedoman')

@section('content')
<div class="admin-header">
    <h1>Kelola KMS / Pedoman</h1>
    <a href="{{ route('admin.kms.kategori.create') }}" class="btn-admin btn-admin-primary">+ Tambah Kategori</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Nama Kategori</th>
            <th>Subkategori</th>
            <th>Total Dokumen</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($kategoris as $kategori)
            <tr>
                <td>{{ $kategori->nama }}</td>
                <td>{{ $kategori->subkategoris_count }}</td>
                <td>{{ $kategori->dokumens_count }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.kms.kategori.show', $kategori) }}" class="btn-admin btn-admin-ghost">Kelola</a>
                    <a href="{{ route('admin.kms.kategori.edit', $kategori) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.kms.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini beserta semua subkategori & dokumen di dalamnya?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada kategori. Klik "Tambah Kategori" untuk membuat yang pertama.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
