@extends('admin.layout')
@section('title', $kategori->nama)

@section('content')
<div class="admin-header">
    <h1>{{ $kategori->nama }}</h1>
    <a href="{{ route('admin.kms.subkategori.create', $kategori) }}" class="btn-admin btn-admin-primary">+ Tambah Subkategori</a>
</div>

<p><a href="{{ route('admin.kmspedoman.index') }}">&larr; Kembali ke daftar kategori</a></p>

<table class="admin-table">
    <thead>
        <tr>
            <th>Nama Subkategori</th>
            <th>Grup Dokumen</th>
            <th>Dokumen Langsung</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($kategori->subkategoris as $sub)
            <tr>
                <td>{{ $sub->nama }}</td>
                <td>{{ $sub->grup_dokumens_count }}</td>
                <td>{{ $sub->dokumens_langsung_count }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.kms.subkategori.show', $sub) }}" class="btn-admin btn-admin-ghost">Kelola</a>
                    <a href="{{ route('admin.kms.subkategori.edit', $sub) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.kms.subkategori.destroy', $sub) }}" method="POST" onsubmit="return confirm('Hapus subkategori ini beserta semua isinya?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada subkategori.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection