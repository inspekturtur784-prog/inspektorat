@extends('admin.layout')
@section('title', 'Edit Kartu Fungsi')

@section('content')
<div class="admin-header">
    <h1>Edit Kartu Fungsi</h1>
</div>

<form class="admin-form" action="{{ route('admin.tugasfungsi.update', $item) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="judul">Judul singkat</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $item->judul) }}" required>
    </div>

    <div class="form-group">
        <label for="deskripsi">Deskripsi (1-2 kalimat)</label>
        <textarea id="deskripsi" name="deskripsi" maxlength="300" required>{{ old('deskripsi', $item->deskripsi) }}</textarea>
    </div>

    <div class="form-group">
        <label for="icon">Ikon</label>
        <select id="icon" name="icon" required>
            @foreach ($ikonList as $key => $label)
                <option value="{{ $key }}" {{ old('icon', $item->icon) === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="urutan">Urutan tampil</label>
        <input type="text" id="urutan" name="urutan" value="{{ old('urutan', $item->urutan) }}">
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan Perubahan</button>
    <a href="{{ route('admin.tugasfungsi.index') }}" class="btn-admin btn-admin-ghost">Batal</a>
</form>
@endsection