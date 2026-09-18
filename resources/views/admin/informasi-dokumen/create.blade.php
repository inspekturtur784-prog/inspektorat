@extends('admin.layout')

@section('title', 'Tambah Dokumen')

@section('content')
<h1>Tambah Dokumen</h1>

<form action="{{ route('admin.informasidokumen.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
    @csrf

    <div class="form-group">
        <label>Judul</label>
        <input type="text" name="judul" value="{{ old('judul') }}" class="form-control" required>
        @error('judul') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="kategori" list="kategori-saran" value="{{ old('kategori') }}" class="form-control" required placeholder="mis. SOP, IKM, Persepsi Korupsi">
        <datalist id="kategori-saran">
            @foreach ($kategoriSaran as $k)
                <option value="{{ $k }}">
            @endforeach
        </datalist>
        @error('kategori') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>
<div class="form-group">
        <label>Keterangan (opsional)</label>
        <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
    </div>

    <div class="form-group">
        <label>File PDF</label>
        <input type="file" name="file" accept="application/pdf" required>
        @error('file') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="admin-btn admin-btn-primary">Simpan</button>
</form>
@endsection
