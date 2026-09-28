@extends('layouts.app')

@section('content')

<style>
    .konsultasi-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 60px 24px 80px;
    }

    .konsultasi-header {
        text-align: center;
        margin-bottom: 45px;
    }

    .konsultasi-label {
        color: #c89b3c;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .konsultasi-header h1 {
        color: #0f2d4f;
        font-size: 42px;
        margin: 0 0 15px;
        font-weight: 700;
    }

    .konsultasi-header p {
        color: #667085;
        font-size: 17px;
        margin: 0;
    }

    .konsultasi-options {
        display: flex;
        justify-content: center;
        margin-bottom: 55px;
    }

    .konsultasi-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(15, 45, 79, 0.06);
        max-width: 420px;
        width: 100%;
    }

    .konsultasi-card h2 {
        color: #0f2d4f;
        font-size: 22px;
        margin: 0 0 12px;
    }

    .konsultasi-card p {
        color: #667085;
        line-height: 1.7;
        margin-bottom: 24px;
    }

    .btn-konsultasi {
        display: inline-block;
        padding: 13px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        transition: 0.2s;
    }

    .btn-whatsapp {
        background: #168c4a;
        color: white;
    }

    .btn-whatsapp:hover {
        background: #11743c;
    }

    @media (max-width: 700px) {
        .konsultasi-page {
            padding: 40px 18px 60px;
        }

        .konsultasi-header h1 {
            font-size: 32px;
        }
    }
</style>

<div class="konsultasi-page">

    <div class="konsultasi-header">
        <div class="konsultasi-label">Layanan Inspektorat</div>
        <h1>Konsultasi Online</h1>
        <p>Silakan hubungi kami melalui WhatsApp untuk konsultasi.</p>
    </div>

    <div class="konsultasi-options">
        <div class="konsultasi-card">
            <h2>Chat via WhatsApp</h2>
            <p>Konsultasi langsung dan cepat melalui WhatsApp bersama Inspektorat Kota Mojokerto.</p>
            <a href="https://wa.me/6281334609981?text=menu" target="_blank" rel="noopener noreferrer" class="btn-konsultasi btn-whatsapp">Chat Sekarang</a>
        </div>
    </div>

</div>

@endsection
