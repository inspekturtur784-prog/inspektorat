@extends('layouts.app')

@section('title', 'Profil Inspektorat — Inspektorat Kota Mojokerto')
@section('meta_description', 'Profil Inspektorat Kota Mojokerto: tentang Inspektorat, kedudukan, peran, tujuan, fungsi, serta visi dan misi.')

@section('content')

{{-- ============ HEADER HALAMAN ============ --}}
<section style="padding:90px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:720px;">
        <span class="eyebrow">Tentang Kami</span>
        <h1 style="font-size:clamp(28px,4vw,42px);margin:16px 0 16px;">Profil Inspektorat</h1>
        <p style="color:var(--slate);font-size:16.5px;">
            Kenali lebih jauh Inspektorat Kota Mojokerto — mulai dari kedudukan,
            peran, tujuan, fungsi, hingga visi dan misi yang kami jalankan.
        </p>
    </div>
</section>

{{-- ============ A. TENTANG INSPEKTORAT ============ --}}
<section style="padding:72px 0;background:var(--paper);" id="tentang">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">A. Tentang Inspektorat</span>
            <h2 style="font-size:clamp(24px,3vw,32px);">Apa itu Inspektorat?</h2>
            <p>
                Inspektorat adalah unsur pengawas penyelenggaraan pemerintahan daerah,
                yang bekerja langsung di bawah dan bertanggung jawab kepada Wali Kota.
                Kami hadir untuk memastikan setiap kebijakan, program, dan penggunaan
                anggaran daerah berjalan sesuai aturan — demi Kota Mojokerto yang
                bersih, akuntabel, dan terpercaya.
            </p>
        </div>

        <div class="definition-list" style="grid-template-columns:repeat(4,1fr);">
            <div class="def-card">
                <span class="seal-mark">K</span>
                <h3>Kedudukan</h3>
                <p>Merupakan unsur pengawas penyelenggaraan Pemerintahan Daerah, dipimpin oleh Inspektur yang berkedudukan di bawah dan bertanggung jawab kepada Wali Kota melalui Sekretaris Daerah Kota.</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">P</span>
                <h3>Peran</h3>
                <p>Menjadi mitra strategis seluruh perangkat daerah dalam mewujudkan tata kelola pemerintahan yang taat aturan dan berintegritas.</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">T</span>
                <h3>Tujuan</h3>
                <p>Mewujudkan penyelenggaraan pemerintahan Kota Mojokerto yang bersih, akuntabel, dan bebas dari korupsi.</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">F</span>
                <h3>Fungsi</h3>
                <p>Melaksanakan audit, reviu, evaluasi, pemantauan, dan bentuk pengawasan lain sesuai kebijakan Wali Kota.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============ B. VISI & MISI ============ --}}
<section class="visimisi" id="visi-misi">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">B. Visi & Misi</span>
            <h2>Arah yang kami tuju</h2>
            <p>Landasan kerja Inspektorat Kota Mojokerto dalam menjalankan tugas pengawasan.</p>
        </div>

        <div class="visimisi-grid">
            <div class="visi-card">
                <span class="vm-label">Visi</span>
                <p class="visi-text">
                    "Terwujudnya pengawasan yang profesional untuk mendukung
                    tata kelola pemerintahan Kota Mojokerto yang bersih,
                    akuntabel, dan berintegritas."
                </p>
            </div>

            <div class="misi-card">
                <span class="vm-label">Misi</span>
                <ol class="misi-list">
                    <li>Meningkatkan kualitas dan profesionalisme aparatur pengawasan internal pemerintah.</li>
                    <li>Mendorong penyelenggaraan pemerintahan daerah yang taat aturan dan bebas dari korupsi, kolusi, dan nepotisme.</li>
                    <li>Memperkuat sistem pengendalian intern pada seluruh perangkat daerah.</li>
                    <li>Membangun budaya integritas dan zona bebas gratifikasi di lingkungan pemerintah kota.</li>
                </ol>
            </div>
        </div>
    </div>
</section>

{{-- ============ C. TUGAS & FUNGSI ============ --}}
<section style="padding:88px 0;background:var(--paper);border-top:1px solid var(--line);" id="tugas-fungsi">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">C. Tugas & Fungsi</span>
            <h2>Apa yang kami kerjakan</h2>
            <p>Penjabaran tugas pokok, fungsi, dan jenis pengawasan yang dijalankan Inspektorat.</p>
        </div>

        <div class="tf-grid">
            <div class="tf-block">
                <span class="vm-label" style="color:var(--gold);border-color:var(--line);">Tugas Pokok</span>
                <p style="color:var(--slate);font-size:15.5px;line-height:1.75;">
                    Membantu Wali Kota membina dan mengawasi pelaksanaan Urusan
                    Pemerintahan yang menjadi kewenangan Daerah dan tugas
                    pembantuan oleh Perangkat Daerah.
                </p>
            </div>

            <div class="tf-block">
                <span class="vm-label" style="color:var(--gold);border-color:var(--line);">Fungsi</span>
                <ul class="tf-list">
                    <li>Perumusan kebijakan teknis bidang pengawasan dan fasilitasi pengawasan.</li>
                    <li>Pelaksanaan pengawasan internal terhadap kinerja dan keuangan melalui audit, reviu, evaluasi, pemantauan, dan kegiatan pengawasan lainnya.</li>
                    <li>Pelaksanaan pengawasan untuk audit dengan tujuan tertentu atas penugasan Wali Kota.</li>
                    <li>Pelaksanaan pengawasan untuk audit investigasi atas penugasan Wali Kota.</li>
                    <li>Pelaksanaan pengawasan untuk audit kinerja atas penugasan Wali Kota.</li>
                    <li>Penyusunan laporan hasil pengawasan.</li>
                    <li>Pelaksanaan administrasi Inspektorat.</li>
                    <li>Pelaksanaan fungsi lain yang diberikan oleh Wali Kota terkait dengan tugas pokok dan fungsinya.</li>
                </ul>
            </div>
        </div>

        <div class="section-head" style="margin-top:56px;margin-bottom:28px;">
            <span class="eyebrow">Jenis Pengawasan</span>
            <h2 style="font-size:22px;">Bentuk pengawasan yang kami jalankan</h2>
        </div>
        <div class="scope-grid">
            <div class="scope-item">
                <span class="scope-num">01</span>
                <p>Audit dengan Tujuan Tertentu (atas penugasan Wali Kota)</p>
            </div>
            <div class="scope-item">
                <span class="scope-num">02</span>
                <p>Audit Investigasi (atas penugasan Wali Kota)</p>
            </div>
            <div class="scope-item">
                <span class="scope-num">03</span>
                <p>Audit Kinerja (atas penugasan Wali Kota)</p>
            </div>
            <div class="scope-item">
                <span class="scope-num">04</span>
                <p>Reviu laporan keuangan & kinerja perangkat daerah</p>
            </div>
            <div class="scope-item">
                <span class="scope-num">05</span>
                <p>Evaluasi penyelenggaraan pemerintahan daerah</p>
            </div>
            <div class="scope-item">
                <span class="scope-num">06</span>
                <p>Pemantauan tindak lanjut hasil pengawasan</p>
            </div>
        </div>
    </div>
</section>

{{-- ============ D. STRUKTUR ORGANISASI ============ --}}
<section class="struktur" id="struktur-organisasi">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">D. Struktur Organisasi</span>
            <h2>Susunan organisasi Inspektorat</h2>
            <p>Klik salah satu bagian untuk melihat detail tugasnya — bukan sekadar bagan gambar.</p>
        </div>

        {{-- Bagan visual sederhana --}}
        <div class="org-chart">
            <div class="org-node org-top">Inspektur</div>
            <div class="org-branch">
                <div class="org-node">Sekretariat</div>
                <div class="org-node">Kelompok Jabatan Fungsional</div>
                <div class="org-node">Irban I</div>
                <div class="org-node">Irban II</div>
                <div class="org-node">Irban III</div>
                <div class="org-node">Irban Khusus</div>
            </div>
        </div>

        {{-- Detail tiap unit — accordion, bisa diklik --}}
        <div class="org-accordion">

            <details class="org-item" open>
                <summary>
                    <span class="org-item-title">Inspektur</span>
                    <span class="org-item-toggle">+</span>
                </summary>
                <div class="org-item-body">
                    <p><strong>Kedudukan:</strong> Pimpinan tertinggi Inspektorat, berkedudukan di bawah dan bertanggung jawab kepada Wali Kota melalui Sekretaris Daerah Kota.</p>
                    <p><strong>Tugas:</strong> Membantu Wali Kota membina dan mengawasi pelaksanaan Urusan Pemerintahan yang menjadi kewenangan Daerah dan tugas pembantuan oleh Perangkat Daerah.</p>
                </div>
            </details>

            <details class="org-item">
                <summary>
                    <span class="org-item-title">Sekretariat</span>
                    <span class="org-item-toggle">+</span>
                </summary>
                <div class="org-item-body">
                    <p><strong>Membawahi:</strong> Subbagian Perencanaan dan Keuangan; Subbagian Umum dan Kepegawaian. Masing-masing dipimpin Kepala Sub Bagian yang bertanggung jawab kepada Sekretaris.</p>
                    <p><strong>Tugas:</strong> Menyelenggarakan penyusunan, perencanaan, dan pengelolaan urusan keuangan, kepegawaian, dan umum, serta mengoordinasikan secara teknis dan administratif pelaksanaan kegiatan dinas.</p>
                    <p><strong>Fungsi Subbag Perencanaan & Keuangan:</strong> penyusunan Renstra & Renja, RKA, DPA/DPPA, Perjanjian Kinerja & IKU, penatausahaan dan pelaporan keuangan, verifikasi SPJ, hingga administrasi gaji pegawai.</p>
                </div>
            </details>

            <details class="org-item">
                <summary>
                    <span class="org-item-title">Kelompok Jabatan Fungsional (Inspektur)</span>
                    <span class="org-item-toggle">+</span>
                </summary>
                <div class="org-item-body">
                    <p><strong>Jabatan:</strong> Auditor Ahli Utama, Auditor Ahli Madya, Pengawas Penyelenggaraan Urusan Pemerintahan Daerah (P2UPD) Ahli Madya, Perencana Ahli Madya.</p>
                    <p><strong>Tugas:</strong> Melaksanakan audit, reviu, evaluasi, dan pemantauan tingkat lanjut yang langsung berada di bawah koordinasi Inspektur.</p>
                </div>
            </details>

            <details class="org-item">
                <summary>
                    <span class="org-item-title">Inspektur Pembantu I</span>
                    <span class="org-item-toggle">+</span>
                </summary>
                <div class="org-item-body">
                    <p><strong>Kelompok Jabatan Fungsional:</strong> Auditor Terampil, Auditor Mahir, Auditor Penyelia, Auditor Ahli Pertama, Auditor Ahli Muda, P2UPD Ahli Pertama, P2UPD Ahli Muda.</p>
                    <p><strong>Tugas:</strong> Melaksanakan pengawasan atas perangkat daerah binaan pada wilayah kerja Irban I.</p>
                </div>
            </details>

            <details class="org-item">
                <summary>
                    <span class="org-item-title">Inspektur Pembantu II</span>
                    <span class="org-item-toggle">+</span>
                </summary>
                <div class="org-item-body">
                    <p><strong>Kelompok Jabatan Fungsional:</strong> Auditor Terampil, Auditor Mahir, Auditor Penyelia, Auditor Ahli Pertama, Auditor Ahli Muda, P2UPD Ahli Pertama, P2UPD Ahli Muda.</p>
                    <p><strong>Tugas:</strong> Melaksanakan pengawasan atas perangkat daerah binaan pada wilayah kerja Irban II.</p>
                </div>
            </details>

            <details class="org-item">
                <summary>
                    <span class="org-item-title">Inspektur Pembantu III</span>
                    <span class="org-item-toggle">+</span>
                </summary>
                <div class="org-item-body">
                    <p><strong>Kelompok Jabatan Fungsional:</strong> Auditor Terampil, Auditor Mahir, Auditor Penyelia, Auditor Ahli Pertama, Auditor Ahli Muda, P2UPD Ahli Pertama, P2UPD Ahli Muda.</p>
                    <p><strong>Tugas:</strong> Melaksanakan pengawasan atas perangkat daerah binaan pada wilayah kerja Irban III.</p>
                </div>
            </details>

            <details class="org-item">
                <summary>
                    <span class="org-item-title">Inspektur Pembantu Khusus</span>
                    <span class="org-item-toggle">+</span>
                </summary>
                <div class="org-item-body">
                    <p><strong>Kelompok Jabatan Fungsional:</strong> Auditor Terampil, Auditor Mahir, Auditor Penyelia, Auditor Ahli Pertama, Auditor Ahli Muda, P2UPD Ahli Pertama, P2UPD Ahli Muda.</p>
                    <p><strong>Tugas:</strong> Menangani penugasan pengawasan khusus, termasuk audit investigasi dan audit dengan tujuan tertentu.</p>
                </div>
            </details>

        </div>

        <p style="color:#B9C2CC;font-size:13px;margin-top:24px;">
            *Nama & identitas pejabat pada tiap bagian ditampilkan di halaman Data Pegawai.
        </p>
    </div>
</section>

{{-- ============ NAVIGASI BAGIAN LAIN (menyusul) ============ --}}
<section style="padding:64px 0 96px;background:var(--paper);">
    <div class="wrap">
        <div class="section-head" style="margin-bottom:32px;">
            <span class="eyebrow">Bagian Lainnya</span>
            <h2 style="font-size:24px;">Jelajahi profil lebih lanjut</h2>
        </div>

        <div class="profil-grid" style="grid-template-columns:1fr 1fr;max-width:780px;">
            <a href="{{ url('/profil/data-pegawai') }}" class="profil-card">
                <div class="profil-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h3>Data Pegawai</h3>
                <p>Daftar pegawai yang bertugas di lingkungan Inspektorat Kota Mojokerto.</p>
                <span class="profil-link">Lihat Bagian Ini
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </span>
            </a>

            <a href="{{ url('/profil/galeri') }}" class="profil-card">
                <div class="profil-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="M21 15l-5-5L5 21"/>
                    </svg>
                </div>
                <h3>Galeri</h3>
                <p>Dokumentasi foto kegiatan, pengawasan, dan sosialisasi Inspektorat.</p>
                <span class="profil-link">Lihat Bagian Ini
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </span>
            </a>
        </div>
    </div>
</section>

@endsection