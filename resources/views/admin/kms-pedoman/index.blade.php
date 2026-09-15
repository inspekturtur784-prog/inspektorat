@extends('admin.layout')
@section('title', 'KMS & Pedoman')

@section('content')
<div class="admin-header"><h1>KMS & Pedoman</h1></div>

@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<h2>Knowledge Base (KMS)</h2>
<div class="admin-header">
    <p>{{ $kmsKategoris->count() }} kategori &middot; {{ $kmsDokumens->count() }} dokumen</p>
    <a href="{{ route('admin.kms.kategori.create') }}" class="btn-admin btn-admin-primary">+ Tambah Kategori KMS</a>
</div>
<table class="admin-table">
    <thead><tr><th>Nama Kategori</th><th>Aksi</th></tr></thead>
    <tbody>
        @forelse ($kmsKategoris as $kategori)
        <tr>
            <td>{{ $kategori->nama }}</td>
            <td class="row-actions">
                <a href="{{ route('admin.kms.kategori.show', $kategori) }}" class="btn-admin btn-admin-ghost">Kelola</a>
                <a href="{{ route('admin.kms.kategori.edit', $kategori) }}" class="btn-admin btn-admin-ghost">Edit</a>
                <form action="{{ route('admin.kms.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini beserta semua isinya?');" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="2">Belum ada kategori KMS.</td></tr>
        @endforelse
    </tbody>
</table>

<h3 style="margin-top:24px;">Semua Dokumen KMS</h3>
<table class="admin-table">
    <thead><tr><th>Judul</th><th>Kategori</th><th>Subkategori</th><th>Grup</th><th>Aksi</th></tr></thead>
    <tbody>
        @forelse ($kmsDokumens as $doc)
        <tr>
            <td>{{ $doc->judul }}</td>
            <td>{{ $doc->kategori->nama ?? '-' }}</td>
            <td>{{ $doc->subkategori->nama ?? '-' }}</td>
            <td>{{ $doc->grupDokumen->nama ?? '-' }}</td>
            <td class="row-actions">
                <a href="{{ asset('kms-files/' . $doc->file_path) }}" target="_blank" class="btn-admin btn-admin-ghost">Lihat</a>
                <a href="{{ route('admin.kms.dokumen.edit', $doc) }}" class="btn-admin btn-admin-ghost">Edit</a>
                <form action="{{ route('admin.kms.dokumen.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">Belum ada dokumen KMS.</td></tr>
        @endforelse
    </tbody>
</table>

<hr style="margin:32px 0;">

<h2>Pedoman</h2>
<div class="admin-header">
    <p>{{ $pedomanKategoris->count() }} kategori &middot; {{ $pedomanDokumens->count() }} dokumen</p>
    <div>
        <a href="{{ route('admin.pedoman.kategori.create') }}" class="btn-admin btn-admin-ghost">+ Tambah Kategori</a>
        <a href="{{ route('admin.pedoman.dokumen.create') }}" class="btn-admin btn-admin-primary">+ Tambah Dokumen</a>
    </div>
</div>
<table class="admin-table">
    <thead><tr><th>Nama Kategori</th><th>Jumlah Dokumen</th><th>Aksi</th></tr></thead>
    <tbody>
        @forelse ($pedomanKategoris as $kategori)
        <tr>
            <td>{{ $kategori->nama }}</td>
            <td>{{ $pedomanDokumens->where('pedoman_kategori_id', $kategori->id)->count() }}</td>
            <td class="row-actions">
                <a href="{{ route('admin.pedoman.kategori.edit', $kategori) }}" class="btn-admin btn-admin-ghost">Edit</a>
                <form action="{{ route('admin.pedoman.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori pedoman ini?');" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="3">Belum ada kategori Pedoman.</td></tr>
        @endforelse
    </tbody>
</table>

<h3 style="margin-top:24px;">Semua Dokumen Pedoman</h3>
<table class="admin-table">
    <thead><tr><th>Judul</th><th>Kategori</th><th>Aksi</th></tr></thead>
    <tbody>
        @forelse ($pedomanDokumens as $doc)
        <tr>
            <td>{{ $doc->judul }}</td>
            <td>{{ $doc->kategori->nama ?? '-' }}</td>
            <td class="row-actions">
                <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn-admin btn-admin-ghost">Lihat</a>
                <a href="{{ route('admin.pedoman.dokumen.edit', $doc) }}" class="btn-admin btn-admin-ghost">Edit</a>
                <form action="{{ route('admin.pedoman.dokumen.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen pedoman ini?');" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="3">Belum ada dokumen Pedoman.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection