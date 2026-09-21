@extends('admin.layout')

@section('title', 'Tambah Dokumen')

@section('content')
<h1>Tambah Dokumen &mdash; {{ $subkategori->nama }}</h1>

@if ($grup)
    <p>Masuk ke grup: <strong>{{ $grup->nama }}</strong></p>
@endif

<form action="{{ route('admin.kms.dokumen.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
    @csrf
    <input type="hidden" name="subkategori_id" value="{{ $subkategori->id }}">
    <input type="hidden" name="grup_dokumen_id" value="{{ $grup->id ?? '' }}">

    <div class="form-group">
        <label>Judul Dokumen</label>
        <input type="text" name="judul" value="{{ old('judul') }}" class="form-control" required>
        @error('judul') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>File PDF atau Video (mp4, mov, avi, wmv, mkv &mdash; maks 100MB)</label>
        <input type="file" name="file" accept="application/pdf,video/*" required>
        @error('file') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection