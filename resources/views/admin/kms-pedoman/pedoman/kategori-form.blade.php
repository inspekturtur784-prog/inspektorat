@extends('admin.layout')

@section('title', $kategori ? 'Edit Kategori Pedoman' : 'Tambah Kategori Pedoman')

@section('content')
<h1>{{ $kategori ? 'Edit Kategori Pedoman' : 'Tambah Kategori Pedoman' }}</h1>

<form action="{{ $kategori ? route('admin.pedoman.kategori.update', $kategori) : route('admin.pedoman.kategori.store') }}" method="POST" class="admin-form">
    @csrf
    @if ($kategori) @method('PUT') @endif
    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama" value="{{ old('nama', $kategori->nama ?? '') }}" class="form-control" required>
        @error('nama') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection