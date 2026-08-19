<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategori->nama }} - Pedoman</title>
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

    {{-- Tab kategori Pedoman --}}
    <div class="px-6 md:px-12 pt-6 pb-4 flex flex-wrap gap-x-6 gap-y-3 border-b border-[#1C2B39]/10">
        @foreach(\App\Models\PedomanKategori::all() as $k)
            <a href="{{ route('pedoman.kategori', $k->slug) }}"
               class="font-medium pb-3 -mb-px text-sm md:text-base {{ $k->id === $kategori->id ? 'maroon border-b-2 border-[#7A1F2B]' : 'text-[#1C2B39]/40 hover:text-[#1C2B39]' }}">
                {{ $k->nama }}
            </a>
        @endforeach
    </div>

    {{-- Judul --}}
    <div class="px-6 md:px-12 pt-10 pb-6">
        <p class="font-mono text-xs gold uppercase tracking-widest mb-2">Pedoman & Regulasi</p>
        <h1 class="font-display text-4xl md:text-5xl maroon">{{ $kategori->nama }}</h1>
    </div>

    {{-- Search & Sort --}}
    <div class="px-6 md:px-12 pb-8">
        <form action="{{ route('pedoman.kategori', $kategori->slug) }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input
                type="text"
                name="cari"
                value="{{ request('cari') }}"
                placeholder="Cari judul dokumen..."
                class="font-mono flex-1 px-4 py-3 rounded-sm border border-[#1C2B39]/20 focus:border-[#7A1F2B] outline-none bg-white"
            >
            <select name="sort" class="font-mono px-4 py-3 rounded-sm border border-[#1C2B39]/20 bg-white">
                <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama</option>
            </select>
            <button type="submit" class="bg-maroon hover:bg-[#5c1620] text-white px-8 py-3 rounded-sm font-semibold tracking-wide transition">
                Filter
            </button>
        </form>
    </div>

    {{-- Daftar dokumen --}}
    <div class="px-6 md:px-12 pb-24 space-y-4">
        @forelse($dokumens as $dokumen)
            <div class="bg-white border border-[#1C2B39]/10 p-5 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 flex items-center justify-center bg-[#7A1F2B]/10 gold font-mono text-xs font-bold uppercase rounded">
                        {{ $dokumen->file_type }}
                    </div>
                    <div>
                        <a href="{{ route('pedoman.detail', [$kategori->slug, $dokumen->id]) }}" class="font-medium hover:maroon hover:underline">
                            {{ $dokumen->judul }}
                        </a>
                        <p class="font-mono text-xs text-[#1C2B39]/40 mt-1">{{ $dokumen->ukuran }} &middot; {{ $dokumen->downloads }} kali dilihat</p>
                    </div>
                </div>
                <a href="{{ route('pedoman.detail', [$kategori->slug, $dokumen->id]) }}"
                   class="bg-[#B08D57] hover:bg-[#9c7a49] text-white px-5 py-2 rounded-sm text-sm font-semibold whitespace-nowrap transition">
                    Lihat
                </a>
            </div>
        @empty
            <p class="text-[#1C2B39]/50 italic">Belum ada dokumen di kategori ini.</p>
        @endforelse
    </div>

</body>
</html>