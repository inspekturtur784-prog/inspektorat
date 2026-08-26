@extends('admin.layout')
@section('title', 'Tentang & Visi Misi')

@section('content')
<div class="admin-header">
    <h1>Tentang Inspektorat & Visi Misi</h1>
</div>

<form class="admin-form" style="max-width:820px;" action="{{ route('admin.pengaturan.update') }}" method="POST">
    @csrf
    @method('PUT')

    <h3 style="font-family:'Fraunces',serif;color:var(--navy);font-size:17px;margin:0 0 16px;">A. Tentang Inspektorat</h3>

    <div class="form-group">
        <label for="tentang_intro">Paragraf pengantar ("Apa itu Inspektorat?")</label>
        <textarea id="tentang_intro" name="tentang_intro" style="min-height:100px;">{{ old('tentang_intro', $p['tentang_intro'] ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <label for="kedudukan">Kedudukan</label>
        <textarea id="kedudukan" name="kedudukan">{{ old('kedudukan', $p['kedudukan'] ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <label for="peran">Peran</label>
        <textarea id="peran" name="peran">{{ old('peran', $p['peran'] ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <label for="tujuan">Tujuan</label>
        <textarea id="tujuan" name="tujuan">{{ old('tujuan', $p['tujuan'] ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <label for="fungsi_singkat">Fungsi (versi singkat, tampil di Beranda & Profil)</label>
        <textarea id="fungsi_singkat" name="fungsi_singkat">{{ old('fungsi_singkat', $p['fungsi_singkat'] ?? '') }}</textarea>
    </div>

    <hr style="border:none;border-top:1px solid #ECEAE2;margin:28px 0;">
    <h3 style="font-family:'Fraunces',serif;color:var(--navy);font-size:17px;margin:0 0 16px;">B. Visi & Misi</h3>

    <div class="form-group">
        <label for="visi">Visi</label>
        <textarea id="visi" name="visi" style="min-height:90px;">{{ old('visi', $p['visi'] ?? '') }}</textarea>
    </div>
    <div class="form-group">
        <label for="misi">Misi (satu poin per baris — akan otomatis jadi list bernomor)</label>
        <textarea id="misi" name="misi" style="min-height:140px;">{{ old('misi', $p['misi'] ?? '') }}</textarea>
    </div>

    <hr style="border:none;border-top:1px solid #ECEAE2;margin:28px 0;">
    <h3 style="font-family:'Fraunces',serif;color:var(--navy);font-size:17px;margin:0 0 16px;">C. Tugas Pokok</h3>

    <div class="form-group">
        <label for="tugas_pokok">Tugas Pokok</label>
        <textarea id="tugas_pokok" name="tugas_pokok">{{ old('tugas_pokok', $p['tugas_pokok'] ?? '') }}</textarea>
    </div>
    <p style="font-size:13px;color:var(--slate);margin-top:-10px;margin-bottom:20px;">
        Daftar kartu "Fungsi" (Perumusan Kebijakan, Pengawasan Internal, dst) dikelola terpisah di menu <a href="{{ route('admin.tugasfungsi.index') }}" style="color:var(--navy);text-decoration:underline;">Tugas & Fungsi</a>.
    </p>

    <button type="submit" class="btn-admin btn-admin-primary">Simpan Semua Perubahan</button>
</form>
@endsection