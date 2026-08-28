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
        body { font-family: 'Inter', sans-serif; background: #EEF1EF; color: #06182E; }
        .font-display { font-family: 'Fraunces', serif; }
        .font-mono { font-family: 'IBM Plex Mono', monospace; }
        .maroon { color: #0B2A4A; }
        .bg-maroon { background-color: #0B2A4A; }
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
        <p class="font-mono text-xs text-right hidden lg:block text-[#06182E]/60">
            Arsip Digital<br>Terverifikasi
        </p>
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
        <a href="{{ route('kms.index') }}" class="font-mono text-xs gold hover:underline">&larr; Kembali ke KMS</a>
    </div>

    <div class="px-6 md:px-12 pt-6 pb-4 flex flex-wrap gap-x-6 gap-y-3 border-b border-[#06182E]/10">
        @foreach(\App\Models\PedomanKategori::all() as $k)
            <a href="{{ route('pedoman.kategori', $k->slug) }}"
               class="font-medium pb-3 -mb-px text-sm md:text-base {{ $k->id === $kategori->id ? 'maroon border-b-2 border-[#0B2A4A]' : 'text-[#06182E]/40 hover:text-[#06182E]' }}">
                {{ $k->nama }}
            </a>
        @endforeach
    </div>

    <div class="px-6 md:px-12 pt-10 pb-6">
        <p class="font-mono text-xs gold uppercase tracking-widest mb-2">Pedoman & Regulasi</p>
        <h1 class="font-display text-4xl md:text-5xl maroon">{{ $kategori->nama }}</h1>
    </div>

    <div class="px-6 md:px-12 mb-16">
        <div class="bg-maroon rounded-sm p-8 md:p-10 relative overflow-hidden bg-gradient-to-br from-[#0B2A4A] to-[#06182E]">
            <div class="absolute top-0 right-0 font-mono text-[10px] text-white/20 p-3">NO. REG-KMS/2026</div>
            <h2 class="font-display text-white text-2xl md:text-3xl mb-6">Cari dokumen di {{ $kategori->nama }}</h2>
            <form action="{{ route('pedoman.kategori', $kategori->slug) }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input
                    type="text"
                    name="cari"
                    value="{{ request('cari') }}"
                    placeholder="Ketik judul atau kata kunci..."
                    class="font-mono flex-1 px-4 py-3 rounded-sm border-2 border-transparent focus:border-[#D4AF6A] outline-none"
                >
                <select name="sort" class="font-mono px-4 py-3 rounded-sm border-2 border-transparent bg-white">
                    <option value="terbaru" {{ request('sort') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama</option>
                </select>
                <button type="submit" class="bg-[#D4AF6A] hover:bg-[#c19a52] text-[#06182E] px-8 py-3 rounded-sm font-semibold tracking-wide transition">
                    Filter
                </button>
            </form>
        </div>
    </div>

    <div class="px-6 md:px-12 pb-24 space-y-4">
        @forelse($dokumens as $dokumen)
            <div class="bg-white border border-[#06182E]/10 p-5 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 flex items-center justify-center bg-[#0B2A4A]/10 gold font-mono text-xs font-bold uppercase rounded">
                        {{ $dokumen->file_type }}
                    </div>
                    <div>
                        <a href="{{ route('pedoman.detail', [$kategori->slug, $dokumen->id]) }}" class="font-medium hover:maroon hover:underline">
                            {{ $dokumen->judul }}
                        </a>
                        <p class="font-mono text-xs text-[#06182E]/40 mt-1">{{ $dokumen->ukuran }} &middot; {{ $dokumen->downloads }} kali dilihat</p>
                    </div>
                </div>
                <a href="{{ route('pedoman.detail', [$kategori->slug, $dokumen->id]) }}"
                   class="bg-[#B08D57] hover:bg-[#9c7a49] text-white px-5 py-2 rounded-sm text-sm font-semibold whitespace-nowrap transition">
                    Lihat
                </a>
            </div>
        @empty
            <p class="text-[#06182E]/50 italic">Belum ada dokumen di kategori ini.</p>
        @endforelse
    </div>

    @if($kategori->slug === 'spip')
    <section class="px-6 md:px-12 pb-24">
        <div class="border-t border-[#06182E]/10 pt-12 mb-10">
            <p class="font-mono text-xs gold uppercase tracking-widest mb-3">Panduan</p>
            <h2 class="font-display text-3xl md:text-4xl maroon mb-2">Petunjuk Teknis Penilaian SPIP</h2>
        </div>

        <div class="grid lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2 space-y-12">

                <div>
                    <h3 class="font-mono text-xs uppercase tracking-widest text-[#06182E]/40 mb-4">01 — Pengertian</h3>
                    <p class="text-[#06182E]/80 leading-relaxed mb-4">
                        Pengertian Sistem Pengendalian Intern menurut PP Nomor 60 Tahun 2008 tentang SPIP adalah:
                    </p>
                    <blockquote class="border-l-4 border-[#B08D57] bg-white pl-5 py-4 pr-4 italic text-[#06182E] leading-relaxed">
                        "Proses yang integral pada tindakan dan kegiatan yang dilakukan secara terus menerus oleh pimpinan dan seluruh pegawai untuk memberikan keyakinan memadai atas tercapainya tujuan organisasi melalui kegiatan yang efektif dan efisien, keandalan pelaporan keuangan, pengamanan aset negara, dan ketaatan terhadap peraturan perundang-undangan."
                    </blockquote>
                </div>

                <div>
                    <h3 class="font-mono text-xs uppercase tracking-widest text-[#06182E]/40 mb-4">02 — Lima Unsur SPIP</h3>
                    <p class="text-[#06182E]/80 leading-relaxed mb-5">
                        Sesuai dengan PP Nomor 60 Tahun 2008, SPIP terdiri dari lima unsur, yaitu:
                    </p>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach([
                            'Lingkungan pengendalian',
                            'Penilaian risiko',
                            'Kegiatan pengendalian',
                            'Informasi dan komunikasi',
                            'Pemantauan pengendalian intern',
                        ] as $i => $unsur)
                            <div class="bg-white border border-[#06182E]/10 px-4 py-3 flex items-center gap-3">
                                <span class="font-mono text-xs gold font-bold">{{ sprintf('%02d', $i + 1) }}</span>
                                <span class="text-sm text-[#06182E]">{{ $unsur }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="font-mono text-xs uppercase tracking-widest text-[#06182E]/40 mb-4">03 — Latar Belakang Penilaian</h3>
                    <div class="text-[#06182E]/80 leading-relaxed space-y-4">
                        <p>
                            Pedoman Penilaian dan Strategi Peningkatan Maturitas Penyelenggaraan Sistem Pengendalian Intern Pemerintah (SPIP) merupakan wujud dari proses governance Pembinaan Penyelenggaraan SPIP dalam rangka pengukuran keberhasilan penyelenggaraan SPIP berdasarkan PP 60 Tahun 2008 pasal 47 ayat (2) huruf b serta pasal 59 ayat (1) dan (2). Pemerintah diwajibkan menyelenggarakan SPIP secara menyeluruh, mulai dari pengenalan konsep dan pedoman untuk penyelenggaraan SPIP, hingga pengukuran keberhasilan penyelenggaraan SPIP dengan metodologi yang dapat mengukur peran SPIP dalam mendukung penyelenggaraan akuntabilitas pengelolaan keuangan negara.
                        </p>
                        <p>
                            Penilaian ini diharapkan menjadi ukuran penyelenggaraan PP 60/2008 tentang SPIP bagi pihak yang terkait dalam pengelolaan keuangan negara.
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="font-mono text-xs uppercase tracking-widest text-[#06182E]/40 mb-4">04 — Prosedur Penilaian</h3>
                    <div class="text-[#06182E]/80 leading-relaxed space-y-4">
                        <p>
                            Penilaian pendahuluan tingkat maturitas SPIP dilakukan untuk mendapatkan informasi awal tingkat maturitas penyelenggaraan SPIP di lingkungan PD. Penilaian dilakukan berdasarkan persepsi pihak yang mewakili Perangkat Daerah terhadap indikator pada setiap unsur penilaian maturitas SPIP. Responden yang mewakili PD haruslah pihak yang paling mengetahui implementasi dari parameter yang ditanyakan.
                        </p>
                        <p>
                            Survai persepsi maturitas SPIP dilaksanakan dengan menggunakan Kuesioner Survei Maturitas SPIP. Pengisian dapat dilakukan dengan atau tanpa didampingi Tim Penilai dari Inspektorat. Pelaksanaan pengisian kuesioner dapat dilakukan secara panel dalam rangka meningkatkan kualitas penilaian — para responden berkumpul dan diharapkan menghasilkan satu jawaban sebagai kesepakatan bersama. Jika didampingi Tim dari Inspektorat, pengisian kuesioner didasarkan pada persepsi responden; Tim Penilai tidak diperkenankan mengarahkan jawaban responden.
                        </p>
                    </div>

                    <p class="text-[#06182E]/80 leading-relaxed mt-4 mb-3">Kuisioner maturitas SPIP diisi oleh:</p>
                    <div class="grid sm:grid-cols-3 gap-3">
                        @foreach([
                            'Pejabat Struktural (eselon II, III, IV)',
                            'Pejabat fungsional khusus (2 orang)',
                            'Pejabat fungsional umum/staf (min. 2 orang)',
                        ] as $peran)
                            <div class="bg-white border border-[#06182E]/10 px-4 py-3 text-sm text-[#06182E]">
                                {{ $peran }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="font-mono text-xs uppercase tracking-widest text-[#06182E]/40 mb-4">05 — Validasi & Wawancara</h3>
                    <div class="text-[#06182E]/80 leading-relaxed space-y-4">
                        <p>
                            Hasil awal Survei Maturitas SPIP masih perlu diuji secara rinci dengan data lapangan. Pengumpulan data rinci maturitas SPIP dapat dilakukan dengan teknik pengumpulan data lainnya seperti wawancara, reviu dokumen, atau observasi — untuk meyakinkan bahwa hasil survai persepsi telah mencerminkan kondisi tingkat maturitas SPIP yang sebenarnya.
                        </p>
                        <p>
                            Dalam rangka pelaksanaan wawancara, telah disediakan form wawancara yang harus diisi oleh responden sesuai perannya masing-masing (lihat kotak referensi di samping).
                        </p>
                        <p>
                            Data dukung kuisioner maturitas SPIP dikirimkan melalui Cloud Storage Inspektorat, diletakkan di dalam folder <span class="font-medium text-[#06182E]">"SPIP"</span> yang telah disiapkan.
                        </p>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <div class="lg:sticky lg:top-6 bg-white border border-[#06182E]/10">
                    <div class="px-5 py-4 border-b border-[#06182E]/10 bg-[#06182E]">
                        <p class="font-mono text-xs uppercase tracking-widest text-[#D4AF6A]">Link & Referensi Terkait</p>
                    </div>
                    <ul class="divide-y divide-[#06182E]/10">
                        <li>
                            <a href="https://bit.ly/questionermaturitasSPIP" target="_blank" class="block px-5 py-4 hover:bg-[#EEF1EF] transition group">
                                <span class="text-sm text-[#06182E] block mb-1">Kuisioner Maturitas SPIP</span>
                                <span class="font-mono text-xs gold group-hover:translate-x-1 transition inline-block">bit.ly/questionermaturitasSPIP →</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://cloud.mojokertokota.go.id/index.php/login" target="_blank" class="block px-5 py-4 hover:bg-[#EEF1EF] transition group">
                                <span class="text-sm text-[#06182E] block mb-1">Cloud Storage — Upload Data Dukung</span>
                                <span class="font-mono text-xs gold group-hover:translate-x-1 transition inline-block">cloud.mojokertokota.go.id →</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://bit.ly/Wawancara-SPIP-Pimpinan" target="_blank" class="block px-5 py-4 hover:bg-[#EEF1EF] transition group">
                                <span class="text-sm text-[#06182E] block mb-1">Form Wawancara — Pimpinan PD</span>
                                <span class="font-mono text-xs gold group-hover:translate-x-1 transition inline-block">bit.ly/Wawancara-SPIP-Pimpinan →</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://bit.ly/SPIP-pegawai" target="_blank" class="block px-5 py-4 hover:bg-[#EEF1EF] transition group">
                                <span class="text-sm text-[#06182E] block mb-1">Form Wawancara — Struktural & Staf</span>
                                <span class="font-mono text-xs gold group-hover:translate-x-1 transition inline-block">bit.ly/SPIP-pegawai →</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://bit.ly/Penilaian_kematangan-MR" target="_blank" class="block px-5 py-4 hover:bg-[#EEF1EF] transition group">
                                <span class="text-sm text-[#06182E] block mb-1">Kuisioner Maturitas Manajemen Risiko</span>
                                <span class="font-mono text-xs gold group-hover:translate-x-1 transition inline-block">bit.ly/Penilaian_kematangan-MR →</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </section>
    @endif

</body>
</html>