@extends('admin.layout')

@section('title', 'Edit Grup Dokumen')

@section('content')
<h1>Edit Grup Dokumen</h1>

<form action="{{ route('admin.kms.grup.update', $grup) }}" method="POST" class="admin-form">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Nama Grup</label>
        <input type="text" name="nama" value="{{ old('nama', $grup->nama) }}" class="form-control" required>
        @error('nama') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection