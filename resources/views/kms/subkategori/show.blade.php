@extends('admin.layout')
@section('title', $subkategori->nama)

@section('content')
<div class="admin-header">
    <h1>{{ $subkategori->nama }}</h1>
    <div>
        <a href="{{ route('admin.kms.grup.create', $subkategori) }}" class="btn-admin btn-admin-ghost">+ Grup Dokumen</a>
        <a href="{{ route('admin.kms.dokumen.create', $subkategori) }}" class="btn-admin btn-admin-primary">+ Tambah Dokumen</a>
    </div>
</div>

<p><a href="{{ route('admin.kms.kategori.show', $subkategori->kategori_id) }}">&larr; Kembali ke {{ $subkategori->kategori->nama }}</a></p>

<h3 style="margin-top:24px;">Grup Dokumen</h3>
<table class="admin-table">
    <thead>
        <tr>
            <th>Nama Grup</th>
            <th>Jumlah Dokumen</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($subkategori->grupDokumens as $grup)
            <tr>
                <td>{{ $grup->nama }}</td>
                <td>{{ $grup->dokumens_count }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.kms.grup.show', $grup) }}" class="btn-admin btn-admin-ghost">Kelola</a>
                    <a href="{{ route('admin.kms.grup.edit', $grup) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.kms.grup.destroy', $grup) }}" method="POST" onsubmit="return confirm('Hapus grup ini beserta dokumennya?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3">Belum ada grup dokumen.</td></tr>
        @endforelse
    </tbody>
</table>

<h3 style="margin-top:24px;">Dokumen Langsung (tanpa grup)</h3>
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
        @forelse ($subkategori->dokumensLangsung as $dokumen)
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
            <tr><td colspan="4">Belum ada dokumen langsung.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
