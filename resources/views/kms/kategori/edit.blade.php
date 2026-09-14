@extends('admin.layout')
@section('title', 'Edit Kategori')

@section('content')
<div class="admin-header"><h1>Edit Kategori KMS</h1></div>

<form action="{{ route('admin.kms.kategori.update', $kategori) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="admin-form-group">
        <label for="nama">Nama Kategori</label>
        <input type="text" name="nama" id="nama" class="admin-input" value="{{ old('nama', $kategori->nama) }}" required>
        @error('nama') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection