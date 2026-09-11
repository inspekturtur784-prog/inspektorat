<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PengaturanProfil;
use App\Models\TugasPokok; // <-- TAMBAHAN

class ProfilController extends Controller
{
    /**
     * Halaman Profil (Lengkap & Resmi)
     */
    public function index()
    {
        $p = class_exists('\App\Models\Profil') ? \App\Models\Profil::first() : null;

        // Data Resmi & Lengkap untuk Halaman Profil
        if (!$p) {
            $p = [
                'kedudukan' => 'Inspektorat Daerah merupakan unsur pengawas penyelenggaraan Pemerintahan Daerah Kota Mojokerto. Inspektorat dipimpin oleh Inspektur yang dalam melaksanakan tugasnya bertanggung jawab langsung kepada Wali Kota melalui Sekretaris Daerah.',

                'peran'     => 'Inspektorat Daerah berperan sebagai Aparat Pengawasan Intern Pemerintah (APIP) yang bertindak sebagai quality assurance dan consulting partner untuk menjamin pelaksanaan urusan pemerintahan daerah berjalan sesuai ketentuan perundang-undangan, serta mencegah terjadinya penyimpangan dan korupsi.',

                'tujuan'    => 'Terwujudnya penyelenggaraan Pemerintahan Daerah Kota Mojokerto yang akuntabel, transparan, efisien, dan bebas dari Praktik KKN (Korupsi, Kolusi, dan Nepotisme) melalui peningkatan efektivitas Sistem Pengendalian Intern Pemerintah (SPIP) dan Kapabilitas APIP.',

                'visi'      => 'Terwujudnya Pengawasan Internal yang Profesional dan Akuntabel Mendorong Tata Kelola Pemerintahan Kota Mojokerto yang Clean Governance dan Good Governance.',

                'misi'      => "Meningkatkan kualitas dan efektivitas pengawasan internal atas penyelenggaraan pemerintahan daerah dan pengelolaan keuangan daerah.\nMeningkatkan tata kelola pemerintahan yang baik, bersih, transparan, dan akuntabel melalui pencegahan korupsi dan optimalisasi SPIP.\nMeningkatkan profesionalisme, integritas, dan kapasitas Sumber Daya Manusia (SDM) Aparat Pengawasan Intern Pemerintah (APIP)."
            ];
        }

        // ================= Satukan sumber dengan halaman Pengaturan =================
        $pengaturan = PengaturanProfil::semua();

        if (!empty($pengaturan['tentang_intro'])) {
            $p['tentang_intro'] = $pengaturan['tentang_intro'];
        }
        if (!empty($pengaturan['visi'])) {
            $p['visi'] = $pengaturan['visi'];
        }
        if (!empty($pengaturan['misi'])) {
            $p['misi'] = $pengaturan['misi'];
        }

        // ================= TAMBAHAN: Tugas Pokok dari tabel tugas_pokok =================
        $tugasPokokTeks = class_exists('\App\Models\TugasPokok')
            ? optional(TugasPokok::urut()->first())->teks
            : null;

        if (!empty($tugasPokokTeks)) {
            $p['tugas_pokok'] = $tugasPokokTeks;
        }
        // ================= AKHIR TAMBAHAN =================

        $misiText = is_array($p) ? ($p['misi'] ?? '') : ($p->misi ?? '');
        $misiList = array_values(array_filter(preg_split('/\r\n|\r|\n/', trim($misiText))));

        $tugasFungsiList = class_exists('\App\Models\TugasFungsi') ? \App\Models\TugasFungsi::all() : collect();
        $strukturList = class_exists('\App\Models\StrukturBagian') ? \App\Models\StrukturBagian::all() : collect();
        $pegawaiPerBidang = class_exists('\App\Models\Pegawai') ? \App\Models\Pegawai::all()->groupBy('bidang') : collect();

        return view('profil', compact('p', 'misiList', 'tugasFungsiList', 'strukturList', 'pegawaiPerBidang'));
    }
}