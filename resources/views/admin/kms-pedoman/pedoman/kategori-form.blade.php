@extends('admin.layout')
@section('title', $kategori ? 'Edit Kategori Pedoman' : 'Tambah Kategori Pedoman')

@section('content')
<div class="admin-header"><h1>{{ $kategori ? 'Edit Kategori Pedoman' : 'Tambah Kategori Pedoman' }}</h1></div>

<form action="{{ $kategori ? route('admin.pedoman.kategori.update', $kategori) : route('admin.pedoman.kategori.store') }}" method="POST">
    @csrf
    @if ($kategori) @method('PUT') @endif
    <div class="admin-form-group">
        <label for="nama">Nama Kategori</label>
        <input type="text" name="nama" id="nama" class="admin-input" value="{{ old('nama', $kategori->nama ?? '') }}" required>
        @error('nama') <div class="admin-error">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection