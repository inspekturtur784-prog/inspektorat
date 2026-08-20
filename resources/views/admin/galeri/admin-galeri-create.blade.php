@extends('admin.layout')
@section('title', 'Tambah Foto Galeri')

@section('content')
<div class="admin-header">
    <h1>Tambah Foto Galeri</h1>
</div>

<form class="admin-form" action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required>
    </div>

    <div class="form-group">
        <label for="kategori">Kategori</label>
        <select id="kategori" name="kategori" required>
            <option value="">— Pilih kategori —</option>
            @foreach ($kategoriList as $kat)
                <option value="{{ $kat }}" {{ old('kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" style="min-height:120px;">{{ old('deskripsi') }}</textarea>
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        <input type="file" id="foto" name="foto" accept="image/*" required>
        <p style="font-size:12.5px;color:var(--slate);margin-top:6px;">
            Foto akan otomatis dikonversi ke format WebP setelah diupload.
        </p>
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan Foto</button>
    <a href="{{ route('admin.galeri.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection