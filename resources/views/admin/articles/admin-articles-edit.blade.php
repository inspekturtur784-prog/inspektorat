@extends('admin.layout')
@section('title', 'Edit Artikel')

@section('content')
<div class="admin-header">
    <h1>Edit Artikel</h1>
</div>

<form class="admin-form" action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="title">Judul</label>
        <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required>
    </div>

    <div class="form-group">
        <label for="excerpt">Ringkasan singkat (tampil di kartu Beranda)</label>
        <textarea id="excerpt" name="excerpt" maxlength="300">{{ old('excerpt', $article->excerpt) }}</textarea>
    </div>

    <div class="form-group">
        <label for="body">Isi lengkap artikel</label>
        <textarea id="body" name="body" style="min-height:220px;">{{ old('body', $article->body) }}</textarea>
    </div>

    <div class="form-group">
        <label for="category">Kategori</label>
        <input type="text" id="category" name="category" value="{{ old('category', $article->category) }}">
    </div>

    <div class="form-group">
        <label for="cover_image">Foto sampul</label>
        @if ($article->cover_image)
            <img src="{{ $article->cover_url }}" alt="" style="width:120px;border-radius:8px;margin-bottom:10px;">
        @endif
        <input type="file" id="cover_image" name="cover_image" accept="image/*">
    </div>

    <div class="form-group">
        <label for="published_at">Tanggal publikasi</label>
        <input type="date" id="published_at" name="published_at"
               value="{{ old('published_at', optional($article->published_at)->format('Y-m-d')) }}">
    </div>

    <div class="form-group checkbox-row">
        <input type="checkbox" id="is_published" name="is_published" value="1" {{ $article->is_published ? 'checked' : '' }}>
        <label for="is_published" style="margin:0;">Tayangkan</label>
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan Perubahan</button>
    <a href="{{ route('admin.articles.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection