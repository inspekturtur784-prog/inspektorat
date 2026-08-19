@extends('admin.layout')
@section('title', 'Tambah Artikel')

@section('content')
<div class="admin-header">
    <h1>Tambah Artikel</h1>
</div>

<form class="admin-form" action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="title">Judul</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" required>
    </div>

    <div class="form-group">
        <label for="excerpt">Ringkasan singkat (tampil di kartu Beranda)</label>
        <textarea id="excerpt" name="excerpt" maxlength="300">{{ old('excerpt') }}</textarea>
    </div>

    <div class="form-group">
        <label for="body">Isi lengkap artikel</label>
        <textarea id="body" name="body" style="min-height:220px;">{{ old('body') }}</textarea>
    </div>

    <div class="form-group">
        <label for="category">Kategori</label>
        <input type="text" id="category" name="category" placeholder="Berita / Pengumuman / Kegiatan" value="{{ old('category') }}">
    </div>

    <div class="form-group">
        <label for="cover_image">Foto sampul</label>
        <input type="file" id="cover_image" name="cover_image" accept="image/*">
    </div>

    <div class="form-group">
        <label for="published_at">Tanggal publikasi</label>
        <input type="date" id="published_at" name="published_at" value="{{ old('published_at', date('Y-m-d')) }}">
    </div>

    <div class="form-group checkbox-row">
        <input type="checkbox" id="is_published" name="is_published" value="1" checked>
        <label for="is_published" style="margin:0;">Tayangkan sekarang</label>
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan Artikel</button>
    <a href="{{ route('admin.articles.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection