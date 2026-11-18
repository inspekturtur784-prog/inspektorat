@extends('layouts.app')

@section('title', 'Kontak Kami — Inspektorat Kota Mojokerto')
@section('meta_description', 'Hubungi Inspektorat Kota Mojokerto — alamat, telepon, email, dan jam layanan.')

@section('content')
{{-- kontak-rapi:start --}}
<style>
.kontak-info{grid-template-columns:repeat(4,1fr)!important;gap:20px!important;align-items:stretch!important;}
.kontak-info .kontak-info-item{
    display:flex!important;flex-direction:column;gap:14px;
    background:#fff;border:1px solid var(--line);border-radius:16px;
    padding:24px;margin:0!important;min-width:0;
    transition:box-shadow .2s ease,transform .2s ease;
}
.kontak-info .kontak-info-item:hover{box-shadow:0 10px 28px rgba(15,35,64,.08);transform:translateY(-2px);}
.kontak-info .kontak-info-item h3{margin:0 0 6px;}
.kontak-info .kontak-info-item p{margin:0;line-height:1.7;overflow-wrap:anywhere;}
.kontak-info .kontak-info-item>div:last-child{min-width:0;}

/* Media Sosial: bar selebar penuh */
.kontak-info .kontak-info-item:nth-child(5){
    grid-column:1/-1;flex-direction:row;align-items:center;gap:18px;
}
.kontak-info .kontak-info-item:nth-child(5)>div:last-child{
    display:flex;align-items:center;gap:18px;flex-wrap:wrap;
}
.kontak-info .kontak-info-item:nth-child(5) h3{margin:0;}
.kontak-info .kontak-info-item:nth-child(5) .footer-social{margin-top:0!important;}

/* Peta */
.kontak-info .kontak-map{
    border-radius:16px;overflow:hidden;border:1px solid var(--line);
    box-shadow:0 6px 20px rgba(15,35,64,.06);
}
.kontak-info .kontak-map iframe{display:block;width:100%;height:380px;border:0;}

@media (max-width:1100px){
    .kontak-info{grid-template-columns:repeat(2,1fr)!important;}
}
@media (max-width:640px){
    .kontak-info{grid-template-columns:1fr!important;}
    .kontak-info .kontak-info-item{padding:20px;}
    .kontak-info .kontak-info-item:nth-child(5){flex-direction:column;align-items:flex-start;}
    .kontak-info .kontak-map iframe{height:280px;}
}
</style>
{{-- kontak-rapi:end --}}

@include('partials.breadcrumb', ['current' => 'Kontak Kami'])

<section style="padding:64px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap">
        <span class="eyebrow">Hubungi Kami</span>
        <h1 style="font-size:clamp(28px,4vw,42px);margin:16px 0 16px;">Kontak Kami</h1>
        <p style="color:var(--slate);font-size:16.5px;max-width:760px;">
            Ada pertanyaan atau ingin datang langsung ke kantor kami? Berikut informasi kontak kami.
        </p>
    </div>
</section>

<section style="padding:56px 0 96px;background:var(--paper);">
    <div class="wrap">
        <div class="kontak-grid" style="display:block;">

            {{-- Kolom kiri: info kontak --}}
            <div class="kontak-info" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:28px 40px;align-items:start;">
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

                <div class="kontak-map" style="grid-column:1/-1;margin-top:8px;">
                    <iframe
                        src="https://www.google.com/maps?q=Jl.+Benteng+Pancasila+No.+23,+Magersari,+Kota+Mojokerto,+Jawa+Timur+61314&output=embed"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi Kantor Inspektorat Kota Mojokerto"></iframe>
                </div>
            </div>


        </div>
    </div>
</section>

@endsection
