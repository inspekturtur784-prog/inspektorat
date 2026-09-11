@extends('admin.layout')
@section('title', 'Tentang Inspektorat & Visi Misi')

@section('content')
<div class="admin-header">
    <h1>Tentang Inspektorat & Visi Misi</h1>
</div>
<p style="color:var(--slate, #5b6b7d);font-size:13.5px;margin:-10px 0 28px;">
    Isi konten ini akan otomatis tampil di halaman beranda publik (section "Mengenal Kami" dan "Visi & Misi").
</p>

<form action="{{ route('admin.pengaturan.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Paragraf Pembuka (Tentang Intro)</label>
        <textarea name="tentang_intro" rows="4" required>{{ old('tentang_intro', $p['tentang_intro'] ?? '') }}</textarea>
    </div>

    <hr style="margin:28px 0;border:none;border-top:1px solid #e5e5e5;">
    <h2 id="visi-misi" style="font-size:17px;margin-bottom:16px;">Visi & Misi</h2>

    <div class="form-group">
        <label>Visi</label>
        <textarea name="visi" rows="3" required>{{ old('visi', $p['visi'] ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label>Misi (satu poin per baris)</label>
        <textarea name="misi" rows="6" required placeholder="Contoh:&#10;Mewujudkan tata kelola pemerintahan yang bersih&#10;Meningkatkan kualitas pengawasan internal">{{ old('misi', $p['misi'] ?? '') }}</textarea>
    </div>

    <button type="submit" class="btn-admin btn-admin-primary" style="margin-top:12px;">Simpan Perubahan</button>
</form>

<hr style="margin:36px 0;border:none;border-top:1px solid #e5e5e5;">

{{--
    ============================================================
    KARTU PROFIL (dulu: Kedudukan, Peran, Tujuan, Fungsi tetap)
    Sekarang: daftar kartu bebas — tambah/edit/hapus sendiri-sendiri.
    Tampilannya sengaja dibikin sama kayak field di atas
    (label + kotak teks), cuma sekarang tiap kartu punya
    tombol Simpan & Hapus sendiri.
    ============================================================
--}}
<h2 style="font-size:17px;margin-bottom:6px;">Kartu Profil (Kedudukan, dll)</h2>
<p style="color:var(--slate, #5b6b7d);font-size:13.5px;margin:0 0 20px;">
    Kartu-kartu ini tampil di section "Mengenal Kami" pada Beranda. Bisa lebih atau kurang dari 4, urutan sesuai angka "Urutan".
</p>

@foreach ($highlights as $item)
    <form action="{{ route('admin.profilhighlight.update', $item) }}" method="POST" style="margin-bottom:22px;padding:18px;border:1px solid #e5e5e5;border-radius:8px;">
        @csrf
        @method('PUT')

        <div style="display:flex;gap:16px;flex-wrap:wrap;margin-bottom:12px;">
            <div class="form-group" style="flex:1;min-width:220px;margin-bottom:0;">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $item->judul) }}" required
                       style="width:100%;padding:10px 12px;border:1px solid #e4e8ee;border-radius:6px;font-size:14px;font-weight:700;">
            </div>
            <div class="form-group" style="width:110px;margin-bottom:0;">
                <label>Urutan</label>
                <input type="number" name="urutan" value="{{ old('urutan', $item->urutan) }}" min="0"
                       style="width:100%;padding:10px 12px;border:1px solid #e4e8ee;border-radius:6px;font-size:14px;">
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="3" required>{{ old('deskripsi', $item->deskripsi) }}</textarea>
        </div>

        <div style="display:flex;gap:10px;">
            <button type="submit" class="btn-admin btn-admin-primary">Simpan Kartu</button>
        </div>
    </form>

    <form action="{{ route('admin.profilhighlight.destroy', $item) }}" method="POST" style="margin:-14px 0 22px;" onsubmit="return confirm('Yakin hapus kartu &quot;{{ $item->judul }}&quot;?');">
        @csrf
        @method('DELETE')
        <button type="submit" style="background:none;border:none;color:#c0392b;cursor:pointer;padding:0;font-size:13px;text-decoration:underline;">
            Hapus kartu ini
        </button>
    </form>
@endforeach

@if ($highlights->isEmpty())
    <p style="color:var(--slate, #5b6b7d);margin-bottom:22px;">Belum ada kartu profil sama sekali. Tambahkan lewat form di bawah.</p>
@endif

{{-- Form untuk menambah kartu baru --}}
<form action="{{ route('admin.profilhighlight.store') }}" method="POST" style="padding:18px;border:1px dashed #c9d2dc;border-radius:8px;background:#f7f8fa;">
    @csrf
    <h3 style="font-size:14.5px;margin:0 0 14px;color:var(--navy,#0b2545);">+ Tambah Kartu Baru</h3>

    <div style="display:flex;gap:16px;flex-wrap:wrap;margin-bottom:12px;">
        <div class="form-group" style="flex:1;min-width:220px;margin-bottom:0;">
            <label>Judul</label>
            <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Kedudukan"
                   style="width:100%;padding:10px 12px;border:1px solid #e4e8ee;border-radius:6px;font-size:14px;">
        </div>
        <div class="form-group" style="width:110px;margin-bottom:0;">
            <label>Urutan</label>
            <input type="number" name="urutan" value="{{ old('urutan', $highlights->count()) }}" min="0"
                   style="width:100%;padding:10px 12px;border:1px solid #e4e8ee;border-radius:6px;font-size:14px;">
        </div>
    </div>

    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" rows="3" placeholder="Penjelasan singkat kartu ini">{{ old('deskripsi') }}</textarea>
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Tambah Kartu</button>
</form>
@endsection