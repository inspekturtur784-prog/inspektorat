@extends('admin.layout')

@section('title', 'Edit Kategori')

@section('content')
<h1>Edit Kategori KMS</h1>

<form action="{{ route('admin.kms.kategori.update', $kategori) }}" method="POST" class="admin-form">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" class="form-control" required>
        @error('nama') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection