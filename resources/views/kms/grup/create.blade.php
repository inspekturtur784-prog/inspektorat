@extends('admin.layout')
@section('title', 'Tambah Grup Dokumen')

@section('content')
<div class="admin-header"><h1>Tambah Grup Dokumen — {{ $subkategori->nama }}</h1></div>

<form action="{{ route('admin.kms.grup.store', $subkategori) }}" method="POST">
    @csrf
    <div class="admin-form-group">
        <label for="nama">Nama Grup</label>
        <input type="text" name="nama" id="nama" class="admin-input" value="{{ old('nama') }}" required>
        @error('nama') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection
