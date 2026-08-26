@extends('admin.layout')
@section('title', 'Kelola Galeri')

@section('content')
<div class="admin-header">
    <h1>Galeri</h1>
    <a href="{{ route('admin.galeri.create') }}" class="btn-admin btn-admin-primary">+ Tambah Foto</a>
</div>

<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;">
    <a href="{{ route('admin.galeri.index') }}"
       class="btn-admin {{ !$kategoriAktif ? 'btn-admin-primary' : 'btn-admin-ghost' }}">Semua</a>
    @foreach ($kategoriList as $kat)
        <a href="{{ route('admin.galeri.index', ['kategori' => $kat]) }}"
           class="btn-admin {{ $kategoriAktif === $kat ? 'btn-admin-primary' : 'btn-admin-ghost' }}">{{ $kat }}</a>
    @endforeach
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $item)
            <tr>
                <td><img src="{{ $item->foto_url }}" alt="" style="width:56px;height:56px;object-fit:cover;border-radius:6px;"></td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->tanggal_indo }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.galeri.edit', $item) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.galeri.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada foto di galeri. Klik "Tambah Foto" untuk mulai.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:20px;">{{ $items->links() }}</div>
@endsection