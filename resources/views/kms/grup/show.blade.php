@extends('admin.layout')
@section('title', $grup->nama)

@section('content')
<div class="admin-header">
    <h1>{{ $grup->nama }}</h1>
    <a href="{{ route('admin.kms.dokumen.create', $grup->subkategori) }}?grup={{ $grup->id }}" class="btn-admin btn-admin-primary">+ Tambah Dokumen</a>
</div>

<p><a href="{{ route('admin.kms.subkategori.show', $grup->subkategori_id) }}">&larr; Kembali ke {{ $grup->subkategori->nama }}</a></p>

<table class="admin-table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Tipe File</th>
            <th>Dilihat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($grup->dokumens as $dokumen)
            <tr>
                <td>{{ $dokumen->judul }}</td>
                <td>{{ strtoupper($dokumen->file_type) }}</td>
                <td>{{ $dokumen->dilihat }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.kms.dokumen.edit', $dokumen) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.kms.dokumen.destroy', $dokumen) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada dokumen di grup ini.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection