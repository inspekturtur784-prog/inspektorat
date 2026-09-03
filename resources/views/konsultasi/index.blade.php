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
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 55px;
    }

    .konsultasi-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(15, 45, 79, 0.06);
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

    .btn-form {
        background: #0f2d4f;
        color: white;
    }

    .btn-form:hover {
        background: #0a2038;
    }

    .form-section {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 8px 25px rgba(15, 45, 79, 0.06);
    }

    .form-section h2 {
        color: #0f2d4f;
        font-size: 30px;
        margin: 0 0 10px;
    }

    .form-section > p {
        color: #667085;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        color: #344054;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 13px 15px;
        border: 1px solid #d0d5dd;
        border-radius: 8px;
        box-sizing: border-box;
        font-size: 15px;
        font-family: inherit;
        outline: none;
    }

    .form-control:focus {
        border-color: #0f2d4f;
        box-shadow: 0 0 0 3px rgba(15, 45, 79, 0.08);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 140px;
    }

    .btn-submit {
        background: #0f2d4f;
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: #0a2038;
    }

    .alert-error {
        background: #fef3f2;
        border: 1px solid #fecdca;
        color: #b42318;
        padding: 15px 18px;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .alert-error ul {
        margin: 5px 0 0;
        padding-left: 20px;
    }

    @media (max-width: 700px) {
        .konsultasi-page {
            padding: 40px 18px 60px;
        }

        .konsultasi-header h1 {
            font-size: 32px;
        }

        .konsultasi-options {
            grid-template-columns: 1fr;
        }

        .form-section {
            padding: 25px 20px;
        }
    }
</style>

<div class="konsultasi-page">

    <div class="konsultasi-header">
        <div class="konsultasi-label">Layanan Inspektorat</div>

        <h1>Konsultasi Online</h1>

        <p>
            Silakan pilih cara konsultasi yang paling nyaman untuk Anda.
        </p>
    </div>


    {{-- Pilihan konsultasi --}}
    <div class="konsultasi-options">

        <div class="konsultasi-card">
            <h2>💬 Chat via WhatsApp</h2>

            <p>
                Konsultasi langsung dan cepat melalui WhatsApp
                bersama Inspektorat Kota Mojokerto.
            </p>

            <a
                href="https://wa.me/6281334609981?text=menu"
                target="_blank"
                rel="noopener noreferrer"
                class="btn-konsultasi btn-whatsapp"
            >
                Chat Sekarang
            </a>
        </div>


        <div class="konsultasi-card">
            <h2>📝 Isi Form Online</h2>

            <p>
                Sampaikan pertanyaan atau permasalahan Anda
                melalui formulir konsultasi online.
            </p>

            <a
                href="#form-konsultasi"
                class="btn-konsultasi btn-form"
            >
                Isi Formulir
            </a>
        </div>

    </div>


    {{-- Form konsultasi --}}
    <div class="form-section" id="form-konsultasi">

        <h2>Formulir Konsultasi</h2>

        <p>
            Silakan lengkapi formulir berikut untuk melakukan
            konsultasi dengan Inspektorat Kota Mojokerto.
        </p>


        @if ($errors->any())
            <div class="alert-error">
                <strong>Mohon periksa kembali data Anda.</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('konsultasi.store') }}" method="POST">

            @csrf

            <div class="form-group">
                <label for="nama">Nama</label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="form-control"
                    value="{{ old('nama') }}"
                    required
                >
            </div>


            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    required
                >
            </div>


            <div class="form-group">
                <label for="no_wa">Nomor WhatsApp</label>

                <input
                    type="text"
                    id="no_wa"
                    name="no_wa"
                    class="form-control"
                    value="{{ old('no_wa') }}"
                    placeholder="Contoh: 628123456789"
                    required
                >
            </div>


            <div class="form-group">
                <label for="instansi">Instansi / Asal</label>

                <input
                    type="text"
                    id="instansi"
                    name="instansi"
                    class="form-control"
                    value="{{ old('instansi') }}"
                >
            </div>


            <div class="form-group">
                <label for="kategori">Kategori Konsultasi</label>

                <select
                    name="kategori"
                    id="kategori"
                    class="form-control"
                    required
                >
                    <option value="">-- Pilih Kategori --</option>

                    <option
                        value="konsultasi"
                        {{ old('kategori') == 'konsultasi' ? 'selected' : '' }}
                    >
                        Konsultasi
                    </option>

                    <option
                        value="gratifikasi"
                        {{ old('kategori') == 'gratifikasi' ? 'selected' : '' }}
                    >
                        Gratifikasi
                    </option>
                </select>
            </div>


            <div class="form-group">
                <label for="pertanyaan">
                    Pertanyaan / Permasalahan
                </label>

                <textarea
                    name="pertanyaan"
                    id="pertanyaan"
                    class="form-control"
                    required
                >{{ old('pertanyaan') }}</textarea>
            </div>


            <button type="submit" class="btn-submit">
                Kirim Konsultasi
            </button>

        </form>

    </div>

</div>

@endsection