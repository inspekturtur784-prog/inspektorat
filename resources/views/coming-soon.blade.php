@extends('layouts.app')

@section('title', ($title ?? 'Halaman') . ' — Inspektorat Kota Mojokerto')

@section('content')
@include('partials.breadcrumb', ['current' => $title ?? 'Halaman'])
<section style="padding:160px 0;text-align:center;">
    <div class="wrap">
        <span class="eyebrow" style="justify-content:center;">Segera Hadir</span>
        <h1 style="margin:16px 0 10px;font-size:32px;">{{ $title ?? 'Halaman ini' }}</h1>
        <p style="color:var(--slate);max-width:48ch;margin:0 auto 26px;">
            Fitur ini sedang kami siapkan dan akan menyusul di pembaruan berikutnya.
        </p>
        <a href="{{ url('/') }}" class="btn btn-gold" style="background:var(--navy);color:#fff;">
            Kembali ke Beranda
        </a>
    </div>
</section>
@endsection