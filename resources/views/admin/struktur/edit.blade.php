@extends('admin.layout')
@section('title', 'Edit Bagian Struktur')

@section('content')
<div class="admin-header">
    <h1>Edit Bagian</h1>
</div>

<form class="admin-form" action="{{ route('admin.struktur.update', $item) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="nama">Nama Bagian</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $item->nama) }}" required>
    </div>

    <div class="form-group">
        <label for="jabatan_desc">Jabatan (penjelasan)</label>
        <textarea id="jabatan_desc" name="jabatan_desc">{{ old('jabatan_desc', $item->jabatan_desc) }}</textarea>
    </div>

    <div class="form-group">
        <label for="tugas">Tugas</label>
        <textarea id="tugas" name="tugas">{{ old('tugas', $item->tugas) }}</textarea>
    </div>

    <div class="form-group">
        <label for="bidang_key">Bidang Key (harus sama persis dengan "Bagian/Unit" di Data Pegawai)</label>
        <input type="text" id="bidang_key" name="bidang_key" value="{{ old('bidang_key', $item->bidang_key) }}">
    </div>

    <div class="form-group checkbox-row">
        <input type="checkbox" id="is_top" name="is_top" value="1" {{ old('is_top', $item->is_top) ? 'checked' : '' }}>
        <label for="is_top" style="margin:0;">Tampilkan sebagai puncak bagan</label>
    </div>

    <div class="form-group">
        <label for="urutan">Urutan tampil</label>
        <input type="text" id="urutan" name="urutan" value="{{ old('urutan', $item->urutan) }}">
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan Perubahan</button>
    <a href="{{ route('admin.struktur.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection