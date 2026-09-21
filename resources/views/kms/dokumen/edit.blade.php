@extends('admin.layout')

@section('title', 'Edit Dokumen')

@section('content')
<h1>Edit Dokumen</h1>

<form action="{{ route('admin.kms.dokumen.update', $dokumen) }}" method="POST" enctype="multipart/form-data" class="admin-form">
    @csrf
    @method('PUT')
    <input type="hidden" name="subkategori_id" value="{{ $dokumen->subkategori_id }}">
    <input type="hidden" name="grup_dokumen_id" value="{{ $dokumen->grup_dokumen_id }}">

    <div class="form-group">
        <label>Judul Dokumen</label>
        <input type="text" name="judul" value="{{ old('judul', $dokumen->judul) }}" class="form-control" required>
        @error('judul') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>File saat ini</label>
        <p><a href="{{ url('/files/' . $dokumen->file_path) }}" target="_blank">{{ $dokumen->file_path }}</a></p>
    </div>

    <div class="form-group">
        <label>Ganti File (kosongkan jika tidak ingin mengubah)</label>
        <input type="file" name="file" accept="application/pdf,video/*">
        @error('file') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection