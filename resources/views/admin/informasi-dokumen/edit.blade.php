@extends('admin.layout')

@section('title', 'Edit Dokumen')

@section('content')
<h1>Edit Dokumen</h1>

<form action="{{ route('admin.informasidokumen.update', $dokumen) }}" method="POST" enctype="multipart/form-data" class="admin-form">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Judul</label>
        <input type="text" name="judul" value="{{ old('judul', $dokumen->judul) }}" class="form-control" required>
        @error('judul') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="kategori" list="kategori-saran" value="{{ old('kategori', $dokumen->kategori) }}" class="form-control" required>
        <datalist id="kategori-saran">
            @foreach ($kategoriSaran as $k)
                <option value="{{ $k }}">
            @endforeach
        </datalist>
        @error('kategori') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Urutan tampil</label>
        <input type="number" name="urutan" value="{{ old('urutan', $dokumen->urutan) }}" class="form-control" min="0">
    </div>

    <div class="form-group">
        <label>Keterangan (opsional)</label>
        <textarea name="keterangan" class="form-control">{{ old('keterangan', $dokumen->keterangan) }}</textarea>
    </div>

    <div class="form-group">
        <label>File PDF saat ini</label><br>
        @if ($dokumen->file_url)
            <a href="{{ $dokumen->file_url }}" target="_blank" rel="noopener">Lihat file sekarang</a>
        @else
            <span>Belum ada file</span>
        @endif
    </div>

    <div class="form-group">
        <label>Ganti file PDF (opsional â€” kosongkan jika tidak diganti)</label>
        <input type="file" name="file" accept="application/pdf">
        @error('file') <div style="color:#b91c1c;font-size:13px;">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="admin-btn admin-btn-primary">Simpan Perubahan</button>
</form>
@endsection
