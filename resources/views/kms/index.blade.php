<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Base - Inspektorat</title>
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
        .border-gold { border-color: #B08D57; }
    </style>
</head>
<body>

    <header class="border-b-2 border-[#06182E] px-6 md:px-12 py-5 flex justify-between items-center">
        <div>
            <p class="font-mono text-xs tracking-widest gold uppercase">Inspektorat Kota Mojokerto</p>
            <a href="{{ route('kms.index') }}" class="font-display font-semibold text-lg hover:text-[#0B2A4A] transition block">
                Knowledge Management System
            </a>
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

    <section class="px-6 md:px-12 pt-16 pb-10 max-w-4xl">
        <p class="font-mono text-xs gold uppercase tracking-widest mb-3">// Ruang Arsip Pengetahuan</p>
        <h1 class="font-display text-6xl md:text-7xl font-medium leading-none maroon">Pusat<br>Pengetahuan</h1>
        <p class="mt-6 text-[#06182E]/70 max-w-md">
            Kumpulan dokumen, materi diklat, dan pedoman pengawasan — tersusun rapi seperti arsip, mudah ditelusuri seperti pustaka digital.
        </p>
    </section>

    <section class="px-6 md:px-12 mb-16">
        <div class="bg-maroon rounded-sm p-8 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 font-mono text-[10px] text-white/20 p-3">NO. REG-KMS/2026</div>
            <h2 class="font-display text-white text-3xl md:text-4xl mb-6">Cari dokumen apa hari ini?</h2>
            <form action="{{ route('kms.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input
                    type="text"
                    name="cari"
                    value="{{ $keyword ?? '' }}"
                    placeholder="Ketik judul atau kata kunci..."
                    class="font-mono flex-1 px-4 py-3 rounded-sm border-2 border-transparent focus:border-[#B08D57] outline-none"
                >
                <button type="submit" class="bg-[#B08D57] hover:bg-[#9c7a49] text-white px-8 py-3 rounded-sm font-medium tracking-wide transition">
                    Telusuri
                </button>
            </form>
        </div>
    </section>

    @if($keyword)
        <section class="px-6 md:px-12 mb-16">
            <p class="font-mono text-xs gold uppercase tracking-widest mb-2">Hasil pencarian</p>
            <h3 class="font-display text-2xl mb-6">"{{ $keyword }}"</h3>
            @forelse($dokumens as $dokumen)
                <div class="border-b border-[#06182E]/10 py-4 flex justify-between items-center">
                    <div>
                        <p class="font-medium">{{ $dokumen->judul }}</p>
                        <p class="text-sm text-[#06182E]/50">{{ $dokumen->kategori->nama }}</p>
                    </div>
                    <span class="font-mono text-xs gold">→</span>
                </div>
            @empty
                <p class="text-[#06182E]/50 italic">Tidak ada dokumen ditemukan untuk kata kunci ini.</p>
            @endforelse
        </section>
    @endif

    <section class="px-6 md:px-12 pb-24">
        <p class="font-mono text-xs gold uppercase tracking-widest mb-6">Kategori Arsip</p>
        <div class="grid md:grid-cols-2 gap-px bg-[#06182E]/10">
            @foreach($kategoris as $index => $kategori)
                <a href="{{ route('kms.kategori', $kategori->slug) }}"
                   class="group bg-[#EEF1EF] hover:bg-white p-6 flex items-center justify-between transition">
                    <div>
                        <span class="font-mono text-xs gold">{{ sprintf('%02d', $index + 1) }} /</span>
                        <p class="font-display text-xl mt-1 maroon group-hover:translate-x-1 transition">
                            {{ $kategori->nama }}
                        </p>
                        <p class="font-mono text-xs text-[#06182E]/40 mt-1">{{ $kategori->dokumens_count }} dokumen tersimpan</p>
                    </div>
                    <span class="font-display text-3xl text-[#06182E]/10 group-hover:text-[#B08D57] transition">→</span>
                </a>
            @endforeach
        </div>
    </section>

</body>
</html>