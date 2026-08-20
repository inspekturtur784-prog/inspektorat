<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konsultasi</title>
</head>

<body>

    <h1>Konsultasi Online</h1>

    <p>
        Silakan isi formulir berikut untuk melakukan konsultasi
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

                <option value="pengaduan">
                    Pengaduan
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