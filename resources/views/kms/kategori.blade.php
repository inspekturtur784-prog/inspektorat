<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategori->nama }} - Knowledge Base</title>
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
        details > summary { list-style: none; cursor: pointer; }
        details > summary::-webkit-details-marker { display: none; }
        details[open] .chevron { transform: rotate(90deg); }
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
        <p class="font-mono text-xs text-right hidden lg:block text-[#06182E]/60">
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
        <a href="{{ route('kms.index') }}" class="font-mono text-xs gold hover:underline">&larr; Kembali ke Beranda</a>
    </div>

    <div class="px-6 md:px-12 pt-6 pb-4 flex overflow-x-auto gap-x-8 border-b border-[#06182E]/10" style="scrollbar-width: none;">
        @foreach(\App\Models\Kategori::all() as $k)
            <a href="{{ route('kms.kategori', $k->slug) }}"
               class="font-medium pb-3 -mb-px whitespace-nowrap flex-shrink-0 {{ $k->id === $kategori->id ? 'maroon border-b-2 border-[#0B2A4A]' : 'text-[#06182E]/40 hover:text-[#06182E]' }}">
                {{ $k->nama }}
            </a>
        @endforeach
    </div>

    <div class="px-6 md:px-12 pt-10 pb-8">
        <p class="font-mono text-xs gold uppercase tracking-widest mb-2">Kategori Arsip</p>
        <h1 class="font-display text-4xl md:text-5xl maroon">{{ $kategori->nama }}</h1>
    </div>

    <div class="px-6 md:px-12 mb-16">
        <div class="bg-maroon rounded-sm p-8 md:p-10 relative overflow-hidden bg-gradient-to-br from-[#0B2A4A] to-[#06182E]">
            <div class="absolute top-0 right-0 font-mono text-[10px] text-white/20 p-3">NO. REG-KMS/2026</div>
            <h2 class="font-display text-white text-2xl md:text-3xl mb-6">Cari dokumen di {{ $kategori->nama }}</h2>
            <form action="{{ route('kms.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input
                    type="text"
                    name="cari"
                    placeholder="Ketik judul atau kata kunci..."
                    class="font-mono flex-1 px-4 py-3 rounded-sm border-2 border-transparent focus:border-[#D4AF6A] outline-none"
                >
                <button type="submit" class="bg-[#D4AF6A] hover:bg-[#c19a52] text-[#06182E] px-8 py-3 rounded-sm font-semibold tracking-wide transition">
                    Telusuri
                </button>
            </form>
        </div>
    </div>

    <div class="px-6 md:px-12 pb-24 grid gap-6 {{ $kategori->subkategoris->count() === 1 ? 'max-w-md mx-auto' : 'md:grid-cols-2 lg:grid-cols-3' }}">
        @php
            $accents = ['#0B2A4A', '#12335A', '#06182E', '#1E4E7A'];
        @endphp
        @forelse($kategori->subkategoris as $index => $sub)
            @php $accent = $accents[$index % count($accents)]; @endphp
            <div class="bg-white border border-[#06182E]/10 shadow-sm hover:shadow-md transition overflow-hidden">
                <div class="px-5 py-4 border-b" style="border-color: {{ $accent }}22; background: linear-gradient(135deg, {{ $accent }}12, transparent);">
                    <span class="font-mono text-xs font-semibold" style="color: {{ $accent }}">{{ sprintf('%02d', $index + 1) }} /</span>
                    <h3 class="font-display text-lg font-semibold" style="color: {{ $accent }}">{{ $sub->nama }}</h3>
                </div>

                <div class="p-5 space-y-1">

                    @foreach($sub->dokumensLangsung as $dokumen)
                        <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="text-sm text-[#06182E] hover:underline flex items-start gap-2 group py-1.5">
                            <span class="font-mono text-xs mt-0.5" style="color: {{ $accent }}">&#9642;</span>
                            <span class="group-hover:translate-x-0.5 transition">{{ $dokumen->judul }}</span>
                        </a>
                    @endforeach

                    @foreach($sub->grupDokumens as $grup)
                        <details class="py-1.5">
                            <summary class="text-sm font-medium flex items-center gap-2 text-[#06182E]/70 hover:text-[#06182E]">
                                <span class="chevron font-mono text-xs transition-transform" style="color: {{ $accent }}">&#9656;</span>
                                <span>{{ $grup->nama }}</span>
                                <span class="font-mono text-[10px] text-[#06182E]/30">({{ $grup->dokumens->count() }})</span>
                            </summary>
                            <div class="pl-6 mt-1 space-y-1 border-l ml-1.5" style="border-color: {{ $accent }}30;">
                                @foreach($grup->dokumens as $dokumen)
                                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="text-sm text-[#06182E]/80 hover:underline flex items-start gap-2 group py-1">
                                        <span class="font-mono text-xs mt-0.5" style="color: {{ $accent }}">&#9642;</span>
                                        <span class="group-hover:translate-x-0.5 transition">{{ $dokumen->judul }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </details>
                    @endforeach

                    @if($sub->dokumensLangsung->isEmpty() && $sub->grupDokumens->isEmpty())
                        <p class="text-sm text-[#06182E]/40 italic py-1.5">Belum ada dokumen</p>
                    @endif

                </div>
            </div>
        @empty
            <p class="text-[#06182E]/50 italic col-span-full">Belum ada sub-kategori untuk kategori ini.</p>
        @endforelse
    </div>

</body>
</html>