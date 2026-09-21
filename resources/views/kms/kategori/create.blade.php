@extends('admin.layout')

@section('title', 'Tambah Kategori')

@section('content')
<h1>Tambah Kategori KMS</h1>

<form action="{{ route('admin.kms.kategori.store') }}" method="POST" class="admin-form">
    @csrf
    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required placeholder="Contoh: Diklat Fungsional Auditor">
        @error('nama') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection