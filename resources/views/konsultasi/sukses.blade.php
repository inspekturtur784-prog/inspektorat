<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konsultasi Berhasil</title>
</head>

<body>

    <h1>Konsultasi Berhasil Dikirim</h1>

    <p>
        Terima kasih. Konsultasi kamu telah berhasil diterima.
    </p>

    <h2>Nomor Tiket</h2>

    <h3>
        {{ $konsultasi->nomor_tiket }}
    </h3>

    <p>
        Simpan nomor tiket tersebut untuk mengecek status konsultasi.
    </p>

    <p>
        Status:
        <strong>{{ $konsultasi->status }}</strong>
    </p>

    <a href="{{ route('konsultasi.index') }}">
        Kembali ke Konsultasi
    </a>

</body>
</html>