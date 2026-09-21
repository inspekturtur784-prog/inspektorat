@extends('admin.layout')

@section('title', $dokumen ? 'Edit Dokumen Pedoman' : 'Tambah Dokumen Pedoman')

@section('content')
<h1>{{ $dokumen ? 'Edit Dokumen Pedoman' : 'Tambah Dokumen Pedoman' }}</h1>

<form action="{{ $dokumen ? route('admin.pedoman.dokumen.update', $dokumen) : route('admin.pedoman.dokumen.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
    @csrf
    @if ($dokumen) @method('PUT') @endif

    <div class="form-group">
        <label>Kategori</label>
        <select name="pedoman_kategori_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategoris as $k)
                <option value="{{ $k->id }}" @selected(old('pedoman_kategori_id', $dokumen->pedoman_kategori_id ?? '') == $k->id)>{{ $k->nama }}</option>
            @endforeach
        </select>
        @error('pedoman_kategori_id') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Judul Dokumen</label>
        <input type="text" name="judul" value="{{ old('judul', $dokumen->judul ?? '') }}" class="form-control" required>
        @error('judul') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    @if ($dokumen)
        <div class="form-group">
            <label>File saat ini</label>
            <p><a href="{{ url('/files/' . $dokumen->file_path) }}" target="_blank">{{ $dokumen->file_path }}</a></p>
        </div>
    @endif

    <div class="form-group">
        <label>{{ $dokumen ? 'Ganti File PDF (kosongkan jika tidak diubah)' : 'File PDF (maks 20MB)' }}</label>
        <input type="file" name="file" accept="application/pdf" {{ $dokumen ? '' : 'required' }}>
        @error('file') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection