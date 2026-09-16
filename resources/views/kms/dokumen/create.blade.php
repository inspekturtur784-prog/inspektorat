@extends('admin.layout')
@section('title', 'Tambah Dokumen')

@section('content')
<style>
    .kp-wrap { font-family:inherit; max-width:560px; }
    .kp-header h1 { font-size:22px; font-weight:700; color:#1e2a4a; margin:0 0 6px; }
    .kp-note { font-size:13px; color:#888; margin:0 0 20px; }
    .kp-field { margin-bottom:18px; }
    .kp-field label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
    .kp-field input, .kp-field textarea { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; font-family:inherit; }
    .kp-error { color:#a3242f; font-size:12px; margin-top:4px; }
    .kp-btn { border:none; cursor:pointer; padding:10px 20px; border-radius:999px; font-size:14px; font-weight:600; }
    .kp-btn-primary { background:#1e2a4a; color:#fff; }
    .kp-btn-primary:hover { background:#28345c; }
</style>

<div class="kp-wrap">
    <div class="kp-header"><h1>Tambah Dokumen &mdash; {{ $subkategori->nama }}</h1></div>
    @if ($grup)
        <p class="kp-note">Masuk ke grup: <strong>{{ $grup->nama }}</strong></p>
    @endif

    <form action="{{ route('admin.kms.dokumen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="subkategori_id" value="{{ $subkategori->id }}">
        <input type="hidden" name="grup_dokumen_id" value="{{ $grup->id ?? '' }}">

        <div class="kp-field">
            <label for="judul">Judul Dokumen</label>
            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required>
            @error('judul') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        <div class="kp-field">
            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea name="deskripsi" id="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        <div class="kp-field">
            <label for="file">File Dokumen (PDF, Word, Excel, PPT &mdash; maks 20MB)</label>
            <input type="file" name="file" id="file" required>
            @error('file') <div class="kp-error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="kp-btn kp-btn-primary">Simpan</button>
    </form>
</div>
@endsection