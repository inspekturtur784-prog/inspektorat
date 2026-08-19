<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedoman - Inspektorat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #EEF1EF; color: #1C2B39; }
        .font-display { font-family: 'Fraunces', serif; }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }
        .maroon { color: #7A1F2B; }
        .bg-maroon { background-color: #7A1F2B; }
        .gold { color: #B08D57; }
    </style>
</head>
<body>

    <header class="border-b-2 border-[#1C2B39] px-6 md:px-12 py-5 flex justify-between items-center">
        <div>
            <p class="font-mono text-xs tracking-widest gold uppercase">Inspektorat Kota Mojokerto</p>
            <a href="{{ route('kms.index') }}" class="font-display font-semibold text-lg hover:text-[#7A1F2B] transition block">
                Knowledge Management System
            </a>
        </div>

        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('pedoman.index') }}" class="font-medium text-sm maroon">Pedoman</a>
        </nav>

        <p class="font-mono text-xs text-right hidden lg:block text-[#1C2B39]/60">
            Arsip Digital<br>Terverifikasi
        </p>
    </header>

    <div class="px-6 md:px-12 pt-6">
        <a href="{{ route('kms.index') }}" class="font-mono text-xs gold hover:underline">&larr; Kembali ke Beranda</a>
    </div>

    <section class="px-6 md:px-12 pt-8 pb-10 max-w-4xl">
        <p class="font-mono text-xs gold uppercase tracking-widest mb-3">// Regulasi & Ketentuan</p>
        <h1 class="font-display text-6xl md:text-7xl font-medium leading-none maroon">Pedoman</h1>
        <p class="mt-6 text-[#1C2B39]/70 max-w-md">
            Kumpulan peraturan, produk hukum, dan pedoman teknis pengawasan Inspektorat Kota Mojokerto.
        </p>
    </section>

    <section class="px-6 md:px-12 pb-24">
        <p class="font-mono text-xs gold uppercase tracking-widest mb-6">Kategori Pedoman</p>
        <div class="grid md:grid-cols-2 gap-px bg-[#1C2B39]/10">
            @foreach($kategoris as $index => $kategori)
                <a href="{{ route('pedoman.kategori', $kategori->slug) }}"
                   class="group bg-[#EEF1EF] hover:bg-white p-6 flex items-center justify-between transition">
                    <div>
                        <span class="font-mono text-xs gold">{{ sprintf('%02d', $index + 1) }} /</span>
                        <p class="font-display text-xl mt-1 maroon group-hover:translate-x-1 transition">
                            {{ $kategori->nama }}
                        </p>
                        <p class="font-mono text-xs text-[#1C2B39]/40 mt-1">{{ $kategori->dokumens_count }} dokumen tersimpan</p>
                    </div>
                    <span class="font-display text-3xl text-[#1C2B39]/10 group-hover:text-[#B08D57] transition">→</span>
                </a>
            @endforeach
        </div>
    </section>

</body>
</html>