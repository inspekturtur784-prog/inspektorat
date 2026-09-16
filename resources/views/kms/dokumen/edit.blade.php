@extends('admin.layout')
@section('title', 'Edit Dokumen')

@section('content')
<style>
    .kp-wrap { font-family:inherit; max-width:560px; }
    .kp-header h1 { font-size:22px; font-weight:700; color:#1e2a4a; margin:0 0 20px; }
    .kp-field { margin-bottom:18px; }
    .kp-field label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
    .kp-field input, .kp-field textarea { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; font-family:inherit; }
    .kp-field p { margin:0; font-size:13px; }
    .kp-field p a { color:#1e2a4a; }
    .kp-error { color:#a3242f; font-size:12px; margin-top:4px; }
    .kp-btn { border:none; cursor:pointer; padding:10px 20px; border-radius:999px; font-size:14px; font-weight:600; }
    .kp-btn-primary { background:#1e2a4a; color:#fff; }
    .kp-btn-primary:hover { background:#28345c; }
</style>

<div class="kp-wrap">
    <div class="kp-header"><h1>Edit Dokumen</h1></div>

    <form action="{{ route('admin.kms.dokumen.update', $dokumen) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="subkategori_id" value="{{ $dokumen->subkategori_id }}">
        <input type="hidden" name="grup_dokumen_id" value="{{ $dokumen->grup_dokumen_id }}">

        <div class="kp-field">
            <label for="judul">Judul Dokumen</label>
            <input type="text" name="judul" id="judul" value="{{ old('judul', $dokumen->judul) }}" required>
            @error('judul') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        <div class="kp-field">
            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea name="deskripsi" id="deskripsi" rows="3">{{ old('deskripsi', $dokumen->deskripsi) }}</textarea>
            @error('deskripsi') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        <div class="kp-field">
            <label>File saat ini</label>
            <p><a href="{{ url('/files/' . $dokumen->file_path) }}" target="_blank">{{ $dokumen->file_path }}</a></p>
        </div>

        <div class="kp-field">
            <label for="file">Ganti File (kosongkan jika tidak ingin mengubah)</label>
            <input type="file" name="file" id="file">
            @error('file') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="kp-btn kp-btn-primary">Simpan</button>
    </form>
</div>
@endsection