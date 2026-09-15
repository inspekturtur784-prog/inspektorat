@extends('admin.layout')
@section('title', $dokumen ? 'Edit Dokumen Pedoman' : 'Tambah Dokumen Pedoman')

@section('content')
<div class="admin-header"><h1>{{ $dokumen ? 'Edit Dokumen Pedoman' : 'Tambah Dokumen Pedoman' }}</h1></div>

<form action="{{ $dokumen ? route('admin.pedoman.dokumen.update', $dokumen) : route('admin.pedoman.dokumen.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($dokumen) @method('PUT') @endif

    <div class="admin-form-group">
        <label for="pedoman_kategori_id">Kategori</label>
        <select name="pedoman_kategori_id" id="pedoman_kategori_id" class="admin-input" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategoris as $k)
                <option value="{{ $k->id }}" @selected(old('pedoman_kategori_id', $dokumen->pedoman_kategori_id ?? '') == $k->id)>{{ $k->nama }}</option>
            @endforeach
        </select>
        @error('pedoman_kategori_id') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-form-group">
        <label for="judul">Judul Dokumen</label>
        <input type="text" name="judul" id="judul" class="admin-input" value="{{ old('judul', $dokumen->judul ?? '') }}" required>
        @error('judul') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <div class="admin-form-group">
        <label for="deskripsi">Deskripsi (opsional)</label>
        <textarea name="deskripsi" id="deskripsi" class="admin-input" rows="3">{{ old('deskripsi', $dokumen->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    @if ($dokumen)
        <div class="admin-form-group">
            <label>File saat ini</label>
            <p><a href="{{ asset($dokumen->file_path) }}" target="_blank">{{ $dokumen->file_path }}</a></p>
        </div>
    @endif

    <div class="admin-form-group">
        <label for="file">{{ $dokumen ? 'Ganti File PDF (kosongkan jika tidak diubah)' : 'File PDF (maks 20MB)' }}</label>
        <input type="file" name="file" id="file" class="admin-input" {{ $dokumen ? '' : 'required' }}>
        @error('file') <div class="admin-error">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection