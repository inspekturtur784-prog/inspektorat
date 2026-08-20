@extends('admin.layout')
@section('title', 'Tambah Pegawai')

@section('content')
<div class="admin-header">
    <h1>Tambah Pegawai</h1>
</div>

<form class="admin-form" action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="nama">Nama Lengkap (dengan gelar)</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
    </div>

    <div class="form-group">
        <label for="jabatan">Jabatan</label>
        <input type="text" id="jabatan" name="jabatan" placeholder="mis. Inspektur Pembantu I" value="{{ old('jabatan') }}" required>
    </div>

    <div class="form-group">
        <label for="bidang">Bidang / Unit</label>
        <input type="text" id="bidang" name="bidang" placeholder="mis. Sekretariat, Irban I, Kelompok Jabatan Fungsional" value="{{ old('bidang') }}">
    </div>

    <div class="form-group">
        <label for="golongan">Pangkat / Golongan Ruang</label>
        <input type="text" id="golongan" name="golongan" placeholder="mis. Pembina Tingkat I (IV/b)" value="{{ old('golongan') }}">
    </div>

    <div class="form-group">
        <label for="nip">NIP (opsional, kosongkan jika tidak dipublikasikan)</label>
        <input type="text" id="nip" name="nip" value="{{ old('nip') }}">
    </div>

    <div class="form-group">
        <label for="urutan">Urutan Tampil (angka kecil tampil lebih dulu, mis. Inspektur = 1)</label>
        <input type="text" id="urutan" name="urutan" value="{{ old('urutan', 99) }}">
    </div>

    <div class="form-group">
        <label for="photo">Foto</label>
        <input type="file" id="photo" name="photo" accept="image/*">
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan Pegawai</button>
    <a href="{{ route('admin.pegawai.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection