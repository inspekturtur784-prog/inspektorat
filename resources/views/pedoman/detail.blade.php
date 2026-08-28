<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $dokumen->judul }} - Pedoman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #EEF1EF; color: #06182E; }
        .font-display { font-family: 'Fraunces', serif; }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }
        .maroon { color: #0B2A4A; }
        .gold { color: #B08D57; }
    </style>
</head>
<body>

    <header class="border-b-2 border-[#06182E] px-6 md:px-12 py-5 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-inspektorat.png') }}" alt="Logo Inspektorat Kota Mojokerto" class="h-12 w-auto">
            <div>
                <p class="font-mono text-xs tracking-widest gold uppercase">Inspektorat Kota Mojokerto</p>
                <a href="{{ route('kms.index') }}" class="font-display font-semibold text-lg hover:text-[#0B2A4A] transition block">
                    Knowledge Management System
                </a>
            </div>
        </div>
    </header>

    <nav class="bg-[#06182E] px-6 md:px-12">
        <div class="flex gap-8">
            <a href="{{ route('kms.index') }}" class="font-mono text-xs uppercase tracking-widest text-white/70 hover:text-white py-3 border-b-2 border-transparent hover:border-[#B08D57] transition">
                Knowledge Base
            </a>
            <a href="{{ route('pedoman.index') }}" class="font-mono text-xs uppercase tracking-widest text-white py-3 border-b-2 border-[#B08D57] transition">
                Pedoman
            </a>
        </div>
    </nav>

    <div class="px-6 md:px-12 pt-6">
        <a href="{{ route('pedoman.kategori', $dokumen->kategori->slug) }}" class="font-mono text-xs gold hover:underline">
            &larr; Kembali ke {{ $dokumen->kategori->nama }}
        </a>
    </div>

    <div class="px-6 md:px-12 pt-8 pb-6">
        <h1 class="font-display text-3xl md:text-4xl maroon mb-3">{{ $dokumen->judul }}</h1>
        <p class="font-mono text-xs text-[#06182E]/50">
            {{ strtoupper($dokumen->file_type) }} &middot; {{ $dokumen->ukuran }} &middot; {{ $dokumen->downloads }} kali dilihat
        </p>
        <a href="{{ asset('storage/' . $dokumen->file_path) }}" download
           class="inline-block mt-4 bg-[#B08D57] hover:bg-[#9c7a49] text-white px-6 py-3 rounded-sm text-sm font-semibold transition">
            &#8681; Download File
        </a>
    </div>

    <div class="px-6 md:px-12 pb-24">
        <div class="bg-white border border-[#06182E]/10" style="height: 85vh;">
            <embed
                src="{{ asset('storage/' . $dokumen->file_path) }}"
                type="application/pdf"
                width="100%"
                height="100%"
            />
        </div>
    </div>

</body>
</html>