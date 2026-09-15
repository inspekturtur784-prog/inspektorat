@extends('admin.layout')
@section('title', 'Edit Dokumen')

@section('content')
<div class="admin-header"><h1>Edit Dokumen</h1></div>

<form action="{{ route('admin.kms.dokumen.update', $dokumen) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="subkategori_id" value="{{ $dokumen->subkategori_id }}">
    <input type="hidden" name="grup_dokumen_id" value="{{ $dokumen->grup_dokumen_id }}">

    <div class="admin-form-group">
        <label for="judul">Judul Dokumen</label>
        <input type="text" name="judul" id="judul" class="admin-input" value="{{ old('judul', $dokumen->judul) }}" required>
        @error('judul') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-form-group">
        <label for="deskripsi">Deskripsi (opsional)</label>
        <textarea name="deskripsi" id="deskripsi" class="admin-input" rows="3">{{ old('deskripsi', $dokumen->deskripsi) }}</textarea>
        @error('deskripsi') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-form-group">
        <label>File saat ini</label>
        <p><a href="{{ asset('kms-files/' . $dokumen->file_path) }}" target="_blank">{{ $dokumen->file_path }}</a></p>
    </div>

    <div class="admin-form-group">
        <label for="file">Ganti File (kosongkan jika tidak ingin mengubah)</label>
        <input type="file" name="file" id="file" class="admin-input">
        @error('file') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection
