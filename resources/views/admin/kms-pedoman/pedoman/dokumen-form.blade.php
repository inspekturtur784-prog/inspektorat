@extends('admin.layout')
@section('title', $dokumen ? 'Edit Dokumen Pedoman' : 'Tambah Dokumen Pedoman')

@section('content')
<style>
    .kp-wrap { font-family:inherit; max-width:560px; }
    .kp-header h1 { font-size:22px; font-weight:700; color:#1e2a4a; margin:0 0 20px; }
    .kp-field { margin-bottom:18px; }
    .kp-field label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
    .kp-field input, .kp-field textarea, .kp-field select { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; font-family:inherit; }
    .kp-field p { margin:0; font-size:13px; }
    .kp-field p a { color:#1e2a4a; }
    .kp-error { color:#a3242f; font-size:12px; margin-top:4px; }
    .kp-btn { border:none; cursor:pointer; padding:10px 20px; border-radius:999px; font-size:14px; font-weight:600; }
    .kp-btn-primary { background:#1e2a4a; color:#fff; }
    .kp-btn-primary:hover { background:#28345c; }
</style>

<div class="kp-wrap">
    <div class="kp-header"><h1>{{ $dokumen ? 'Edit Dokumen Pedoman' : 'Tambah Dokumen Pedoman' }}</h1></div>

    <form action="{{ $dokumen ? route('admin.pedoman.dokumen.update', $dokumen) : route('admin.pedoman.dokumen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($dokumen) @method('PUT') @endif

        <div class="kp-field">
            <label for="pedoman_kategori_id">Kategori</label>
            <select name="pedoman_kategori_id" id="pedoman_kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $k)
                    <option value="{{ $k->id }}" @selected(old('pedoman_kategori_id', $dokumen->pedoman_kategori_id ?? '') == $k->id)>{{ $k->nama }}</option>
                @endforeach
            </select>
            @error('pedoman_kategori_id') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        <div class="kp-field">
            <label for="judul">Judul Dokumen</label>
            <input type="text" name="judul" id="judul" value="{{ old('judul', $dokumen->judul ?? '') }}" required>
            @error('judul') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        <div class="kp-field">
            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea name="deskripsi" id="deskripsi" rows="3">{{ old('deskripsi', $dokumen->deskripsi ?? '') }}</textarea>
            @error('deskripsi') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        @if ($dokumen)
            <div class="kp-field">
                <label>File saat ini</label>
                <p><a href="{{ asset($dokumen->file_path) }}" target="_blank">{{ $dokumen->file_path }}</a></p>
            </div>
        @endif

        <div class="kp-field">
            <label for="file">{{ $dokumen ? 'Ganti File PDF (kosongkan jika tidak diubah)' : 'File PDF (maks 20MB)' }}</label>
            <input type="file" name="file" id="file" {{ $dokumen ? '' : 'required' }}>
            @error('file') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="kp-btn kp-btn-primary">Simpan</button>
    </form>
</div>
@endsection