@extends('layouts.app')

@section('title', 'Layanan — Inspektorat Kota Mojokerto')
@section('meta_description', 'Layanan pengawasan intern, audit, konsultasi online, dan pengaduan Inspektorat Kota Mojokerto.')

@section('content')

@include('partials.breadcrumb', ['current' => 'Layanan'])

{{-- Header Halaman --}}
<section style="padding:64px 0 30px; background:var(--paper); border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:720px;">
        <span class="eyebrow">Layanan Kami</span>
        <h1 style="font-size:clamp(28px,4vw,42px); margin:16px 0 16px;">Layanan Inspektorat</h1>
        <p style="color:var(--slate); font-size:16.5px;">
            Daftar lengkap layanan pengawasan intern, pemeriksaan/audit, serta kanal pengaduan publik.
        </p>
    </div>
</section>

{{-- BAGIAN 1: Detail Audit (Dari Web Lama) --}}
<section style="padding:56px 0; background:var(--paper); border-bottom:1px solid var(--line);">
    <div class="wrap">
        <span class="eyebrow">Pengawasan Intern</span>
        <h2 style="font-size:28px; color:var(--navy); margin:12px 0 24px;">Layanan Audit & Pemeriksaan</h2>
        
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:24px;">
            <div style="background:#fff; padding:28px; border-radius:12px; border:1px solid var(--line);">
                <h3 style="color:var(--navy); margin-bottom:12px; font-size:20px;">a. Audit Keuangan</h3>
                <p style="color:var(--slate); font-size:14.5px; line-height:1.6; margin-bottom:16px;">
                    Audit atas laporan keuangan untuk memberikan opini secara independen menggunakan Standar Pemeriksaan Keuangan Negara (SPKN).
                </p>
                <strong style="color:var(--navy); font-size:14px;">Cakupan Audit Keuangan:</strong>
                <ul style="color:var(--slate); font-size:14px; margin-top:8px; padding-left:18px; line-height:1.7;">
                    <li>Audit Laporan Pendapatan dan Biaya</li>
                    <li>Audit Laporan Penerimaan dan Pengeluaran Kas</li>
                    <li>Audit Laporan Aktiva Tetap & Permintaan Anggaran</li>
                    <li>Audit Pengelolaan Keuangan Dana Dekonsentrasi</li>
                </ul>
            </div>

            <div style="background:#fff; padding:28px; border-radius:12px; border:1px solid var(--line);">
                <h3 style="color:var(--navy); margin-bottom:12px; font-size:20px;">b. Audit Kinerja</h3>
                <p style="color:var(--slate); font-size:14.5px; line-height:1.6; margin-bottom:16px;">
                    Audit terhadap aspek pengelolaan keuangan dan pelaksanaan tugas daerah dengan sasaran <strong>3E (Ekonomis, Efisiensi, dan Efektivitas)</strong> serta ketaatan peraturan.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- BAGIAN 2: 7 Layanan Publik --}}
<section style="padding:56px 0 96px; background:var(--paper);">
    <div class="wrap">
        <span class="eyebrow">Publik & Konsultasi</span>
        <h2 style="font-size:28px; color:var(--navy); margin:12px 0 24px;">Layanan Interaktif & Pengaduan</h2>
        
        {{-- Masukkan 7 card layanan kamu di sini --}}

    </div>
</section>

@endsection