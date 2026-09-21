@extends('admin.layout')

@section('title', 'Tambah Grup Dokumen')

@section('content')
<h1>Tambah Grup Dokumen &mdash; {{ $subkategori->nama }}</h1>

<form action="{{ route('admin.kms.grup.store', $subkategori) }}" method="POST" class="admin-form">
    @csrf
    <div class="form-group">
        <label>Nama Grup</label>
        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>
        @error('nama') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection