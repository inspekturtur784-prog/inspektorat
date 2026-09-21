@extends('admin.layout')

@section('title', 'Edit Subkategori')

@section('content')
<h1>Edit Subkategori</h1>

<form action="{{ route('admin.kms.subkategori.update', $subkategori) }}" method="POST" class="admin-form">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Nama Subkategori</label>
        <input type="text" name="nama" value="{{ old('nama', $subkategori->nama) }}" class="form-control" required>
        @error('nama') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection