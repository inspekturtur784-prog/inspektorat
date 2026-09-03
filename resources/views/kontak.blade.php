@extends('layouts.app')

@section('title', 'Kontak Kami — Inspektorat Kota Mojokerto')
@section('meta_description', 'Hubungi Inspektorat Kota Mojokerto — alamat, telepon, email, jam layanan, dan formulir pesan.')

@section('content')

@include('partials.breadcrumb', ['current' => 'Kontak Kami'])

<section style="padding:64px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:720px;">
        <span class="eyebrow">Hubungi Kami</span>
        <h1 style="font-size:clamp(28px,4vw,42px);margin:16px 0 16px;">Kontak Kami</h1>
        <p style="color:var(--slate);font-size:16.5px;">
            Ada pertanyaan atau ingin datang langsung ke kantor kami? Berikut informasi kontak dan formulir pesan.
        </p>
    </div>
</section>

<section style="padding:56px 0 96px;background:var(--paper);">
    <div class="wrap">
        <div class="kontak-grid">

            {{-- Kolom kiri: info kontak --}}
            <div class="kontak-info">
                <div class="kontak-info-item">
                    <div class="kontak-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 12-9 12s-9-5-9-12a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <h3>Alamat</h3>
                        <p>Jl. Benteng Pancasila No. 23, Magersari, Kota Mojokerto, Jawa Timur 61314</p>
                    </div>
                </div>

                <div class="kontak-info-item">
                    <div class="kontak-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <h3>Telepon</h3>
                        <p>(0321) 399630</p>
                    </div>
                </div>

                <div class="kontak-info-item">
                    <div class="kontak-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M22 6l-10 7L2 6"/></svg>
                    </div>
                    <div>
                        <h3>Email</h3>
                        <p>inspektorat@mojokertokota.go.id</p>
                    </div>
                </div>

                <div class="kontak-info-item">
                    <div class="kontak-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div>
                        <h3>Jam Layanan</h3>
                        <p>Senin – Kamis: 07.30 – 15.30 WIB<br>Jumat: 07.30 – 14.30 WIB<br>Sabtu, Minggu & Libur Nasional: Tutup</p>
                    </div>
                </div>

                <div class="kontak-info-item">
                    <div class="kontak-info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="M8.6 13.5l6.8 4M15.4 6.5l-6.8 4"/></svg>
                    </div>
                    <div>
                        <h3>Media Sosial</h3>
                        <div class="footer-social" style="margin-top:6px;">
                            <a href="#" aria-label="Instagram" style="border-color:var(--line);color:var(--navy);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                            </a>
                            <a href="#" aria-label="Facebook" style="border-color:var(--line);color:var(--navy);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 3h-2a5 5 0 0 0-5 5v2H6v4h2v7h4v-7h3l1-4h-4V8a1 1 0 0 1 1-1h3z"/></svg>
                            </a>
                            <a href="#" aria-label="YouTube" style="border-color:var(--line);color:var(--navy);">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="4"/><path d="M10 9l5 3-5 3z" fill="currentColor" stroke="none"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="kontak-map">
                    <iframe
                        src="https://www.google.com/maps?q=Jl.+Benteng+Pancasila+No.+23,+Magersari,+Kota+Mojokerto,+Jawa+Timur+61314&output=embed"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi Kantor Inspektorat Kota Mojokerto"></iframe>
                </div>
            </div>

            {{-- Kolom kanan: form pesan --}}
            <div class="kontak-form-wrap">
                <h2 style="font-size:20px;color:var(--navy);margin:0 0 6px;">Kirim Pesan</h2>
                <p style="color:var(--slate);font-size:14px;margin:0 0 20px;">Isi formulir di bawah, tim kami akan membalas ke email Anda.</p>

                @if (session('status'))
                    <div class="kontak-alert-success">{{ session('status') }}</div>
                @endif

                <form action="{{ route('kontak.store') }}" method="POST" class="kontak-form">
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
                        @error('nama') <p class="kontak-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <p class="kontak-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="telepon">No. Telepon (opsional)</label>
                        <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}">
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" style="min-height:140px;" required>{{ old('pesan') }}</textarea>
                        @error('pesan') <p class="kontak-error">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn-gold kontak-submit-btn">
                        Kirim Pesan
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection