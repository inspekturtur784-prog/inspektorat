@extends('admin.layout')
@section('title', $kategori ? 'Edit Kategori Pedoman' : 'Tambah Kategori Pedoman')

@section('content')
<style>
    .kp-wrap { font-family:inherit; max-width:480px; }
    .kp-header h1 { font-size:22px; font-weight:700; color:#1e2a4a; margin:0 0 20px; }
    .kp-field { margin-bottom:18px; }
    .kp-field label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
    .kp-field input { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; }
    .kp-error { color:#a3242f; font-size:12px; margin-top:4px; }
    .kp-btn { border:none; cursor:pointer; padding:10px 20px; border-radius:999px; font-size:14px; font-weight:600; }
    .kp-btn-primary { background:#1e2a4a; color:#fff; }
    .kp-btn-primary:hover { background:#28345c; }
</style>

<div class="kp-wrap">
    <div class="kp-header"><h1>{{ $kategori ? 'Edit Kategori Pedoman' : 'Tambah Kategori Pedoman' }}</h1></div>

    <form action="{{ $kategori ? route('admin.pedoman.kategori.update', $kategori) : route('admin.pedoman.kategori.store') }}" method="POST">
        @csrf
        @if ($kategori) @method('PUT') @endif
        <div class="kp-field">
            <label for="nama">Nama Kategori</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $kategori->nama ?? '') }}" required>
            @error('nama') <div class="kp-error">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="kp-btn kp-btn-primary">Simpan</button>
    </form>
</div>
@endsection