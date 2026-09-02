@extends('admin.layout')
@section('title', 'Kelola Galeri')

@section('content')
<div class="admin-header">
    <h1>Galeri Kegiatan</h1>
    <a href="{{ route('admin.galeri.create') }}" class="btn-admin btn-admin-primary">+ Tambah Foto</a>
</div>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px; padding: 10px 15px; background-color: #d4edda; color: #155724; border-radius: 6px;">
        {{ session('success') }}
    </div>
@endif

<table class="admin-table">
    <thead>
        <tr>
            <th style="width: 80px;">Foto</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($galeris as $item)
            <tr>
           <td>
    @if (!empty($item->foto_url))
        <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}" style="width: 60px; height: 45px; object-fit: cover; border-radius: 6px;">
    @elseif (!empty($item->foto))
        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" style="width: 60px; height: 45px; object-fit: cover; border-radius: 6px;">
    @else
        <span class="badge badge-off">No Photo</span>
    @endif
</td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->kategori ?? 'Umum' }}</td>
                <td>{{ $item->tanggal_indo ?? $item->created_at->format('d M Y') }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.galeri.edit', $item) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.galeri.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus foto galeri ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada foto galeri. Klik "Tambah Foto" untuk membuat yang pertama.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:20px;">
    {{ $galeris->links() }}
</div>
@endsection