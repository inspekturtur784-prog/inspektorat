<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategori->nama }} - Knowledge Base Inspektorat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #EEF1EF; color: #06182E; }
        .font-display { font-family: 'Fraunces', serif; }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }
        .maroon { color: #0B2A4A; }
        .bg-maroon { background-color: #0B2A4A; }
        .gold { color: #B08D57; }
    </style>
</head>
<body>

    <header class="bg-[#06182E] border-b border-white/10 px-6 md:px-12 py-5 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-inspektorat.png') }}" alt="Logo Inspektorat Kota Mojokerto" class="h-12 w-auto">
            <div>
                <p class="font-mono text-xs tracking-widest gold uppercase">Inspektorat Kota Mojokerto</p>
                <a href="{{ route('kms.index') }}" class="font-display font-semibold text-lg text-white hover:text-[#D4AF6A] transition block">
                    Knowledge Management System &amp; Pedoman
                </a>
            </div>
        </div>
        <p class="font-mono text-xs text-right hidden lg:block text-white/60">
            Arsip Digital<br>Terverifikasi
        </p>
    </header>

    <nav class="bg-[#06182E] px-6 md:px-12">
        <div class="flex gap-8">
            <a href="{{ route('kms.index') }}" class="font-mono text-xs uppercase tracking-widest text-white py-3 border-b-2 border-[#B08D57] transition">
                Knowledge Base
            </a>
            <a href="{{ route('pedoman.index') }}" class="font-mono text-xs uppercase tracking-widest text-white/70 hover:text-white py-3 border-b-2 border-transparent hover:border-[#B08D57] transition">
                Pedoman
            </a>
        </div>
    </nav>

    <div class="px-6 md:px-12 pt-6">
        <a href="{{ route('kms.index') }}" class="font-mono text-xs gold hover:underline">&larr; Kembali ke Kategori Arsip</a>
    </div>

    <div class="px-6 md:px-12 pt-6 pb-4 flex overflow-x-auto gap-x-6 border-b border-[#06182E]/10" style="scrollbar-width: none;">
        @foreach(\App\Models\Kategori::all() as $k)
            <a href="{{ route('kms.kategori', $k->slug) }}"
               class="font-medium pb-3 -mb-px text-sm md:text-base whitespace-nowrap flex-shrink-0 {{ $k->id === $kategori->id ? 'maroon border-b-2 border-[#0B2A4A]' : 'text-[#06182E]/40 hover:text-[#06182E]' }}">
                {{ $k->nama }}
            </a>
        @endforeach
    </div>

    <div class="px-6 md:px-12 pt-10 pb-6">
        <p class="font-mono text-xs gold uppercase tracking-widest mb-2">Arsip Pengetahuan</p>
        <h1 class="font-display text-4xl md:text-5xl maroon">{{ $kategori->nama }}</h1>
    </div>

    <div class="px-6 md:px-12 mb-16">
        <div class="bg-maroon rounded-sm p-8 md:p-10 relative overflow-hidden bg-gradient-to-br from-[#0B2A4A] to-[#06182E]">
            <div class="absolute top-0 right-0 font-mono text-[10px] text-white/20 p-3">NO. REG-KMS/2026</div>
            <h2 class="font-display text-white text-2xl md:text-3xl mb-6">Cari dokumen di {{ $kategori->nama }}</h2>
            <form action="{{ route('kms.kategori', $kategori->slug) }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input
                    type="text"
                    name="cari"
                    value="{{ request('cari') }}"
                    placeholder="Ketik judul atau kata kunci..."
                    class="font-mono flex-1 px-4 py-3 rounded-sm border-2 border-transparent focus:border-[#D4AF6A] outline-none"
                >
                <button type="submit" class="bg-[#D4AF6A] hover:bg-[#c19a52] text-[#06182E] px-8 py-3 rounded-sm font-semibold tracking-wide transition">
                    Telusuri
                </button>
            </form>
        </div>
    </div>

    <section class="px-6 md:px-12 pb-24">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($kategori->subkategoris as $index => $subkategori)
                <div class="bg-white rounded-sm p-6 shadow-sm">
                    <p class="font-mono text-xs gold mb-1">{{ sprintf('%02d', $index + 1) }} /</p>
                    <h2 class="font-display text-xl font-semibold maroon mb-4">{{ $subkategori->nama }}</h2>

                    <ul class="space-y-2 text-sm">
                        @foreach($subkategori->dokumensLangsung as $dokumen)
                            <li class="flex items-start gap-2">
                                <span class="gold mt-1">&bull;</span>
                                <a href="{{ url('/files/' . $dokumen->file_path) }}" target="_blank" class="hover:underline hover:maroon">
                                    {{ $dokumen->judul }}
                                </a>
                            </li>
                        @endforeach

                        @foreach($subkategori->grupDokumens as $grup)
                            <li>
                                <details class="group">
                                    <summary class="flex items-center gap-2 cursor-pointer list-none text-[#06182E]/70 hover:text-[#06182E]">
                                        <span class="text-xs">&#9656;</span>
                                        <span>{{ $grup->nama }}</span>
                                        <span class="font-mono text-xs text-[#06182E]/40">({{ $grup->dokumens->count() }})</span>
                                    </summary>
                                    <ul class="mt-2 ml-5 space-y-2">
                                        @foreach($grup->dokumens as $dokumen)
                                            <li class="flex items-start gap-2">
                                                <span class="gold mt-1">&bull;</span>
                                                <a href="{{ url('/files/' . $dokumen->file_path) }}" target="_blank" class="hover:underline">
                                                    {{ $dokumen->judul }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </details>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-[#06182E]/50 italic">Belum ada dokumen di kategori ini.</p>
            @endforelse
        </div>
    </section>

</body>
</html>