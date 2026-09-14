@extends('admin.layout')
@section('title', 'Tambah Dokumen')

@section('content')
<div class="admin-header"><h1>Tambah Dokumen — {{ $subkategori->nama }}</h1></div>

<form action="{{ route('admin.kms.dokumen.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="subkategori_id" value="{{ $subkategori->id }}">
    <input type="hidden" name="grup_dokumen_id" value="{{ $grup->id ?? '' }}">

    @if ($grup)
        <p>Masuk ke grup: <strong>{{ $grup->nama }}</strong></p>
    @endif

    <div class="admin-form-group">
        <label for="judul">Judul Dokumen</label>
        <input type="text" name="judul" id="judul" class="admin-input" value="{{ old('judul') }}" required>
        @error('judul') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-form-group">
        <label for="deskripsi">Deskripsi (opsional)</label>
        <textarea name="deskripsi" id="deskripsi" class="admin-input" rows="3">{{ old('deskripsi') }}</textarea>
        @error('deskripsi') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-form-group">
        <label for="file">File Dokumen (PDF, Word, Excel, PPT — maks 20MB)</label>
        <input type="file" name="file" id="file" class="admin-input" required>
        @error('file') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection