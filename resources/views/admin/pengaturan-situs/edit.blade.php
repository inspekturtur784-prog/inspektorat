@extends('admin.layout')
@section('title', 'Pengaturan Situs')
@section('content')

<style>
.ps-wrap { max-width: 960px; }
.ps-intro { color: #6b7280; margin: 0 0 20px; }
.ps-ok { background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; }
.ps-fail { background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; }
.ps-card { background: #fff; border-radius: 14px; padding: 24px 26px; margin-bottom: 18px; box-shadow: 0 1px 3px rgba(0,0,0,.06); border-top: 3px solid #1e2a4a; }
.ps-card h2 { font-size: 16px; margin: 0 0 4px; }
.ps-desc { color: #6b7280; font-size: 13px; margin: 0 0 18px; }
.ps-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.ps-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
.ps-field label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #1f2937; }
.ps-field input, .ps-field textarea { width: 100%; padding: 10px 12px; border: 1px solid #d6d3cd; border-radius: 10px; background: #fff; font: inherit; font-size: 14px; box-sizing: border-box; }
.ps-field input:focus, .ps-field textarea:focus { outline: none; border-color: #1e2a4a; box-shadow: 0 0 0 3px rgba(30,42,74,.12); }
.ps-invalid input, .ps-invalid textarea { border-color: #dc2626; }
.ps-hint { font-size: 12px; color: #6b7280; margin-top: 6px; line-height: 1.5; }
.ps-err { font-size: 12px; color: #b91c1c; margin-top: 4px; }
.ps-bar { position: sticky; bottom: 0; background: linear-gradient(to top, #f2f0eb 70%, rgba(242,240,235,0)); padding: 16px 0 8px; display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
.ps-note { font-size: 13px; color: #6b7280; }
@media (max-width: 760px) { .ps-grid, .ps-grid-3 { grid-template-columns: 1fr; } }
</style>

<div class="ps-wrap">
    <div class="admin-header">
        <h1 class="admin-header-sub">Pengaturan Situs</h1>
    </div>
    <p class="ps-intro">Atur kontak dan media sosial yang tampil di footer website. Perubahan langsung terlihat di halaman publik setelah disimpan.</p>

    @if (session('status_situs'))
        <div class="ps-ok">{{ session('status_situs') }}</div>
    @endif

    @if ($errors->any())
        <div class="ps-fail">Ada isian yang belum sesuai. Periksa kolom yang diberi tanda merah di bawah.</div>
    @endif

    <form method="POST" action="{{ route('admin.pengaturan-situs.update') }}">
        @csrf
        @method('PUT')

        <div class="ps-card">
            <h2>Kontak Kantor</h2>
            <p class="ps-desc">Alamat, telepon, dan email yang tampil di bagian Kontak footer.</p>

            <div class="ps-field @error('kontak_alamat') ps-invalid @enderror" style="margin-bottom:16px;">
                <label for="kontak_alamat">Alamat</label>
                <textarea id="kontak_alamat" name="kontak_alamat" rows="3">{{ old('kontak_alamat', $s['kontak_alamat'] ?? '') }}</textarea>
                @error('kontak_alamat')<div class="ps-err">{{ $message }}</div>@enderror
            </div>

            <div class="ps-grid">
                <div class="ps-field @error('kontak_telepon') ps-invalid @enderror">
                    <label for="kontak_telepon">Telepon</label>
                    <input type="text" id="kontak_telepon" name="kontak_telepon" value="{{ old('kontak_telepon', $s['kontak_telepon'] ?? '') }}">
                    @error('kontak_telepon')<div class="ps-err">{{ $message }}</div>@enderror
                </div>
                <div class="ps-field @error('kontak_email') ps-invalid @enderror">
                    <label for="kontak_email">Email</label>
                    <input type="email" id="kontak_email" name="kontak_email" value="{{ old('kontak_email', $s['kontak_email'] ?? '') }}">
                    @error('kontak_email')<div class="ps-err">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="ps-card">
            <h2>Jam Layanan</h2>
            <p class="ps-desc">Tampil di kolom Jam Layanan pada footer.</p>

            <div class="ps-field @error('kontak_jam_layanan') ps-invalid @enderror">
                <label for="kontak_jam_layanan">Jam layanan</label>
                <textarea id="kontak_jam_layanan" name="kontak_jam_layanan" rows="8">{{ old('kontak_jam_layanan', $s['kontak_jam_layanan'] ?? '') }}</textarea>
                <div class="ps-hint">Tulis satu keterangan per baris. Kosongkan satu baris untuk memisahkan kelompok hari, misalnya nama hari di satu baris lalu jamnya di baris berikutnya.</div>
                @error('kontak_jam_layanan')<div class="ps-err">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="ps-card">
            <h2>Lokasi Peta</h2>
            <p class="ps-desc">Peta Google Maps yang tampil di footer.</p>

            <div class="ps-field @error('kontak_maps_embed') ps-invalid @enderror">
                <label for="kontak_maps_embed">Link peta</label>
                <input type="url" id="kontak_maps_embed" name="kontak_maps_embed" value="{{ old('kontak_maps_embed', $s['kontak_maps_embed'] ?? '') }}">
                <div class="ps-hint">Buka Google Maps, pilih Bagikan, lalu Sematkan peta. Salin isi bagian src dari kode yang muncul.</div>
                @error('kontak_maps_embed')<div class="ps-err">{{ $message }}</div>@enderror
            </div>

            @if (($s['kontak_maps_embed'] ?? '') !== '')
                <iframe src="{{ $s['kontak_maps_embed'] }}" loading="lazy" title="Pratinjau peta" style="width:100%;height:200px;border:0;border-radius:10px;margin-top:14px;"></iframe>
            @endif
        </div>

        <div class="ps-card">
            <h2>Media Sosial</h2>
            <p class="ps-desc">Ikon hanya tampil di footer kalau linknya diisi.</p>

            <div class="ps-grid-3">
                <div class="ps-field @error('sosmed_facebook') ps-invalid @enderror">
                    <label for="sosmed_facebook">Facebook</label>
                    <input type="url" id="sosmed_facebook" name="sosmed_facebook" placeholder="https://www.facebook.com/..." value="{{ old('sosmed_facebook', $s['sosmed_facebook'] ?? '') }}">
                    @error('sosmed_facebook')<div class="ps-err">{{ $message }}</div>@enderror
                </div>
                <div class="ps-field @error('sosmed_instagram') ps-invalid @enderror">
                    <label for="sosmed_instagram">Instagram</label>
                    <input type="url" id="sosmed_instagram" name="sosmed_instagram" placeholder="https://www.instagram.com/..." value="{{ old('sosmed_instagram', $s['sosmed_instagram'] ?? '') }}">
                    @error('sosmed_instagram')<div class="ps-err">{{ $message }}</div>@enderror
                </div>
                <div class="ps-field @error('sosmed_youtube') ps-invalid @enderror">
                    <label for="sosmed_youtube">YouTube</label>
                    <input type="url" id="sosmed_youtube" name="sosmed_youtube" placeholder="https://www.youtube.com/..." value="{{ old('sosmed_youtube', $s['sosmed_youtube'] ?? '') }}">
                    @error('sosmed_youtube')<div class="ps-err">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="ps-bar">
            <button type="submit" class="btn-admin">Simpan Perubahan</button>
            <span class="ps-note">Kolom yang dikosongkan tidak akan ditampilkan di footer.</span>
        </div>
    </form>
</div>
@endsection