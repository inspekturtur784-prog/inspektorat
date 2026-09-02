<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konsultasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
            color: #222;
        }
        .pilihan-wrap {
            display: flex;
            gap: 16px;
            margin: 24px 0 40px;
            flex-wrap: wrap;
        }
        .kartu-pilihan {
            flex: 1;
            min-width: 240px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }
        .kartu-pilihan h3 {
            margin-top: 0;
        }
        .btn-wa {
            display: inline-block;
            background: #25D366;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-form {
            display: inline-block;
            background: #0F2750;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }
        hr {
            margin: 40px 0;
            border: none;
            border-top: 1px solid #ddd;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            max-width: 400px;
            padding: 8px;
            margin-top: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background: #0F2750;
            color: white;
            padding: 10px 22px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h1>Konsultasi Online</h1>

    <p>
        Silakan pilih cara konsultasi yang paling nyaman untuk Anda.
    </p>

    <div class="pilihan-wrap">

        <div class="kartu-pilihan">
            <h3>💬 Chat via WhatsApp</h3>
            <p>Konsultasi langsung dan cepat lewat WhatsApp.</p>
            
                href="https://wa.me/6281334609981?text=menu"
                target="_blank"
                class="btn-wa"
            >
                Chat Sekarang
            </a>
        </div>

        <div class="kartu-pilihan">
            <h3>📝 Isi Form Online</h3>
            <p>Isi formulir di bawah, dapatkan nomor tiket untuk pelacakan.</p>
            <a href="#form-konsultasi" class="btn-form">
                Isi Formulir
            </a>
        </div>

    </div>

    <hr>

    <h2 id="form-konsultasi">Formulir Konsultasi</h2>

    <p>
        Atau, silakan isi formulir berikut untuk melakukan konsultasi
        dengan Inspektorat Kota Mojokerto.
    </p>

    <form action="{{ route('konsultasi.store') }}" method="POST">

        @csrf

        <div>
            <label>Nama</label><br>
            <input
                type="text"
                name="nama"
                value="{{ old('nama') }}"
                required
            >
        </div>

        <br>

        <div>
            <label>Email</label><br>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <br>

        <div>
            <label>Nomor WhatsApp</label><br>
            <input
                type="text"
                name="no_wa"
                value="{{ old('no_wa') }}"
                placeholder="Contoh: 628123456789"
                required
            >
        </div>

        <br>

        <div>
            <label>Instansi / Asal</label><br>
            <input
                type="text"
                name="instansi"
                value="{{ old('instansi') }}"
            >
        </div>

        <br>

        <div>
            <label>Kategori Konsultasi</label><br>

            <select name="kategori" required>

                <option value="">
                    -- Pilih Kategori --
                </option>

                <option value="konsultasi">
                    Konsultasi
                </option>

                <option value="gratifikasi">
                    Gratifikasi
                </option>

            </select>

        </div>

        <br>

        <div>
            <label>Pertanyaan / Permasalahan</label><br>

            <textarea
                name="pertanyaan"
                rows="6"
                cols="50"
                required
            >{{ old('pertanyaan') }}</textarea>

        </div>

        <br>

        <button type="submit">
            Kirim Konsultasi
        </button>

    </form>

</body>
</html>