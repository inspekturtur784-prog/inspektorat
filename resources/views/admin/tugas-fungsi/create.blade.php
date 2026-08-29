@extends('admin.layout')
@section('title', 'Tambah Kartu Fungsi')

@section('content')
<div class="admin-header">
    <h1>Tambah Kartu Fungsi</h1>
</div>

<form class="admin-form" action="{{ route('admin.tugasfungsi.store') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="judul">Judul singkat</label>
        <input type="text" id="judul" name="judul" placeholder="mis. Perumusan Kebijakan" value="{{ old('judul') }}" required>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi (1-2 kalimat)</label>
        <textarea id="deskripsi" name="deskripsi" maxlength="300" required>{{ old('deskripsi') }}</textarea>
    </div>

    <div class="form-group">
        <label for="icon">Ikon</label>
        <select id="icon" name="icon" required>
            @foreach ($ikonList as $key => $label)
                <option value="{{ $key }}" {{ old('icon') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="urutan">Urutan tampil</label>
        <input type="text" id="urutan" name="urutan" value="{{ old('urutan', 99) }}">
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
    <a href="{{ route('admin.tugasfungsi.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection