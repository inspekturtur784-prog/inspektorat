@extends('admin.layout')
@section('title', 'Tambah Bagian Struktur')

@section('content')
<div class="admin-header">
    <h1>Tambah Bagian</h1>
</div>

<form class="admin-form" action="{{ route('admin.struktur.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="nama">Nama Bagian</label>
        <input type="text" id="nama" name="nama" placeholder="mis. Inspektur Pembantu IV" value="{{ old('nama') }}" required>
    </div>

    <div class="form-group">
        <label for="jabatan_desc">Jabatan (penjelasan)</label>
        <textarea id="jabatan_desc" name="jabatan_desc">{{ old('jabatan_desc') }}</textarea>
    </div>

    <div class="form-group">
        <label for="tugas">Tugas</label>
        <textarea id="tugas" name="tugas">{{ old('tugas') }}</textarea>
    </div>

    <div class="form-group">
        <label for="bidang_key">Bidang Key (harus sama persis dengan "Bagian/Unit" di Data Pegawai)</label>
        <input type="text" id="bidang_key" name="bidang_key" placeholder="mis. Irban IV" value="{{ old('bidang_key') }}">
    </div>

    <div class="form-group checkbox-row">
        <input type="checkbox" id="is_top" name="is_top" value="1" {{ old('is_top') ? 'checked' : '' }}>
        <label for="is_top" style="margin:0;">Tampilkan sebagai puncak bagan (biasanya cuma untuk "Inspektur")</label>
    </div>

    <div class="form-group">
        <label for="urutan">Urutan tampil</label>
        <input type="text" id="urutan" name="urutan" value="{{ old('urutan', 99) }}">
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
    <a href="{{ route('admin.struktur.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection