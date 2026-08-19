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
        body { font-family: 'Inter', sans-serif; background: #EEF1EF; color: #1C2B39; }
        .font-display { font-family: 'Fraunces', serif; }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }
        .maroon { color: #7A1F2B; }
        .bg-maroon { background-color: #7A1F2B; }
        .gold { color: #B08D57; }
    </style>
</head>
<body>

    {{-- Header --}}
    <header class="border-b-2 border-[#1C2B39] px-6 md:px-12 py-5 flex justify-between items-center">
        <div>
            <p class="font-mono text-xs tracking-widest gold uppercase">Inspektorat Kota Mojokerto</p>
            <a href="{{ route('kms.index') }}" class="font-display font-semibold text-lg hover:text-[#7A1F2B] transition block">
                Knowledge Management System
            </a>
        </div>
        <p class="font-mono text-xs text-right hidden md:block text-[#1C2B39]/60">
            Arsip Digital<br>Terverifikasi
        </p>
    </header>

    {{-- Breadcrumb --}}
    <div class="px-6 md:px-12 pt-6">
        <a href="{{ route('kms.index') }}" class="font-mono text-xs gold hover:underline">&larr; Kembali ke Beranda</a>
    </div>

    {{-- Tab kategori --}}
    <div class="px-6 md:px-12 pt-6 pb-4 flex flex-wrap gap-x-8 gap-y-3 border-b border-[#1C2B39]/10">
        @foreach(\App\Models\Kategori::all() as $k)
            <a href="{{ route('kms.kategori', $k->slug) }}"
               class="font-medium pb-3 -mb-px {{ $k->id === $kategori->id ? 'maroon border-b-2 border-[#7A1F2B]' : 'text-[#1C2B39]/40 hover:text-[#1C2B39]' }}">
                {{ $k->nama }}
            </a>
        @endforeach
    </div>

    {{-- Judul kategori --}}
    <div class="px-6 md:px-12 pt-10 pb-8">
        <p class="font-mono text-xs gold uppercase tracking-widest mb-2">Kategori Arsip</p>
        <h1 class="font-display text-4xl md:text-5xl maroon">{{ $kategori->nama }}</h1>
    </div>

    {{-- Grid Sub-kategori --}}
    <div class="px-6 md:px-12 pb-24 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($kategori->subkategoris as $index => $sub)
            <div class="bg-white border border-[#1C2B39]/10">
                <div class="px-5 py-4 border-b border-[#1C2B39]/10 bg-[#EEF1EF]">
                    <span class="font-mono text-xs gold">{{ sprintf('%02d', $index + 1) }} /</span>
                    <h3 class="font-display text-lg font-semibold">{{ $sub->nama }}</h3>
                </div>
                <ul class="p-5 space-y-3">
                    @forelse($sub->dokumens as $dokumen)
                        <li>
                            <a href="#" class="text-sm hover:maroon hover:underline flex items-start gap-2">
                                <span class="gold font-mono text-xs mt-0.5">&#9642;</span>
                                <span>{{ $dokumen->judul }}</span>
                            </a>
                        </li>
                    @empty
                        <li class="text-sm text-[#1C2B39]/40 italic">Belum ada dokumen</li>
                    @endforelse
                </ul>
            </div>
        @empty
            <p class="text-[#1C2B39]/50 italic col-span-full">Belum ada sub-kategori untuk kategori ini.</p>
        @endforelse
    </div>

</body>
</html>