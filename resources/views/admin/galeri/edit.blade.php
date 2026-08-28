@extends('admin.layout')
@section('title', 'Edit Foto Galeri')

@section('content')
<div class="admin-header">
    <h1>Edit Foto Galeri</h1>
</div>

<form class="admin-form" action="{{ route('admin.galeri.update', $galeri) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}" required>
    </div>

    <div class="form-group">
        <label for="kategori">Kategori</label>
        <input type="text" id="kategori" name="kategori" list="kategori-saran"
               value="{{ old('kategori', $galeri->kategori) }}" required>
        <datalist id="kategori-saran">
            @if (isset($kategoriSaran) && count($kategoriSaran) > 0)
                @foreach ($kategoriSaran as $kat)
                    <option value="{{ $kat }}">
                @endforeach
            @endif
        </datalist>
    </div>

    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', is_string($galeri->tanggal) ? $galeri->tanggal : $galeri->tanggal?->format('Y-m-d')) }}" required>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" style="min-height:120px;">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        @if (!empty($galeri->foto_url))
            <img src="{{ $galeri->foto_url }}" alt="" style="width:140px;border-radius:8px;margin-bottom:10px;display:block;">
        @endif
        <input type="file" id="foto" name="foto" accept="image/*">
        <p style="font-size:12.5px;color:var(--slate);margin-top:6px;">
            Kosongkan jika tidak ingin mengganti foto.
        </p>
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan Perubahan</button>
    <a href="{{ route('admin.galeri.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection