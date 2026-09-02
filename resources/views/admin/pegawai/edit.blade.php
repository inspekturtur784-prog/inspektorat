@extends('admin.layout')
@section('title', 'Edit Pegawai')

@section('content')
<div class="admin-header">
    <h1>Edit Pegawai</h1>
</div>

<form class="admin-form" action="{{ route('admin.pegawai.update', $pegawai) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nama">Nama Lengkap (dengan gelar)</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $pegawai->nama) }}" required>
    </div>

    <div class="form-group">
        <label for="jabatan">Jabatan</label>
        <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}" required>
    </div>

    <div class="form-group">
        <label for="bidang">Bidang / Unit</label>
        <input type="text" id="bidang" name="bidang" value="{{ old('bidang', $pegawai->bidang) }}">
    </div>

    <div class="form-group">
        <label for="golongan">Pangkat / Golongan Ruang</label>
        <input type="text" id="golongan" name="golongan" value="{{ old('golongan', $pegawai->golongan) }}">
    </div>

    <div class="form-group">
        <label for="tugas">Tugas</label>
        <textarea id="tugas" name="tugas">{{ old('tugas', $pegawai->tugas) }}</textarea>
    </div>

    <div class="form-group">
        <label for="fungsi">Fungsi</label>
        <textarea id="fungsi" name="fungsi">{{ old('fungsi', $pegawai->fungsi) }}</textarea>
    </div>

    <div class="form-group">
        <label for="nip">NIP (opsional)</label>
        <input type="text" id="nip" name="nip" value="{{ old('nip', $pegawai->nip) }}">
    </div>

    <div class="form-group">
        <label for="urutan">Urutan Tampil</label>
        <input type="text" id="urutan" name="urutan" value="{{ old('urutan', $pegawai->urutan) }}">
    </div>

    <div class="form-group">
        <label for="foto">Foto</label>
        @if (!empty($pegawai->foto_url))
            <img src="{{ $pegawai->foto_url }}" alt="Preview Foto" style="width:90px; height:90px; object-fit:cover; border-radius:8px; margin-bottom:10px; display:block;">
        @elseif (!empty($pegawai->foto))
            <img src="{{ asset('storage/' . $pegawai->foto) }}" alt="Preview Foto" style="width:90px; height:90px; object-fit:cover; border-radius:8px; margin-bottom:10px; display:block;">
        @endif
        <input type="file" id="foto" name="foto" accept="image/*">
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan Perubahan</button>
    <a href="{{ route('admin.pegawai.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection