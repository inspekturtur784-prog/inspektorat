@extends('admin.layout')

@section('title', 'Tambah Subkategori')

@section('content')
<h1>Tambah Subkategori &mdash; {{ $kategori->nama }}</h1>

<form action="{{ route('admin.kms.subkategori.store', $kategori) }}" method="POST" class="admin-form">
    @csrf
    <div class="form-group">
        <label>Nama Subkategori</label>
        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>
        @error('nama') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection