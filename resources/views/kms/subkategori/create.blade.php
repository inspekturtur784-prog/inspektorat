@extends('admin.layout')
@section('title', 'Tambah Subkategori')

@section('content')
<div class="admin-header"><h1>Tambah Subkategori — {{ $kategori->nama }}</h1></div>

<form action="{{ route('admin.kms.subkategori.store', $kategori) }}" method="POST">
    @csrf
    <div class="admin-form-group">
        <label for="nama">Nama Subkategori</label>
        <input type="text" name="nama" id="nama" class="admin-input" value="{{ old('nama') }}" required>
        @error('nama') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection
