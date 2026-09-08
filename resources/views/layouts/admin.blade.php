<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Inspektorat Kota Mojokerto</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">

    <!-- Topbar khusus HP/tablet -->
    <div class="admin-topbar">
        <button type="button" class="admin-topbar-toggle" id="adminSidebarToggle" aria-label="Buka menu">
            <span></span><span></span><span></span>
        </button>
        <span class="admin-topbar-title">Admin Inspektorat</span>
    </div>

    <div class="admin-overlay" id="adminSidebarOverlay"></div>

    <div class="admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                    <img src="{{ asset('images/logo-mojokerto.png') }}" alt="Logo">
                    <span>Admin Inspektorat</span>
                </a>
                <nav>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>

                    <span class="admin-nav-label">Profil</span>
                    <a href="{{ route('admin.pengaturan.edit') }}" class="admin-nav-sub {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                        Tentang Inspektorat
                    </a>
                    <a href="{{ route('admin.pengaturan.edit') }}#visi-misi" class="admin-nav-sub">
                        Visi & Misi
                    </a>
                    <a href="{{ route('admin.tugasfungsi.index') }}" class="admin-nav-sub {{ request()->routeIs('admin.tugasfungsi.*') ? 'active' : '' }}">
                        Tugas & Fungsi
                    </a>
                    <a href="{{ route('admin.struktur.index') }}" class="admin-nav-sub {{ request()->routeIs('admin.struktur.*') ? 'active' : '' }}">
                        Struktur Organisasi
                    </a>
                    <a href="{{ route('admin.pegawai.index') }}" class="admin-nav-sub {{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">
                        Data Pegawai
                    </a>
                    <a href="{{ route('admin.galeri.index') }}" class="admin-nav-sub {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                        Galeri
                    </a>

                    <span class="admin-nav-label">Konten Lain</span>
                    <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                        Artikel / Informasi
                    </a>
                    <a href="{{ route('admin.pesan.index') }}" class="{{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}" style="display:flex;justify-content:space-between;align-items:center;">
                        <span>Pesan Masuk</span>
                        @php $belumDibaca = \App\Models\Pesan::where('is_read', false)->count(); @endphp
                        @if ($belumDibaca > 0)
                            <span class="admin-nav-badge">{{ $belumDibaca }}</span>
                        @endif
                    </a>
                </nav>
            </div>

            <div class="admin-sidebar-footer">
                <div class="admin-user">
                    <span class="admin-user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <span class="admin-user-email">{{ auth()->user()->email ?? '' }}</span>
                </div>
                <a href="{{ route('admin.password.edit') }}" class="admin-sidebar-link">Ganti Kata Sandi</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="admin-sidebar-link admin-logout-btn">Keluar</button>
                </form>
            </div>
        </aside>

        <!-- Tempat konten dinamis tiap halaman ditampilkan -->
        <main class="admin-main">
            @if (session('status'))
                <div class="admin-alert">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>
    </div>

    <script>
        (function () {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('adminSidebarOverlay');
            var toggle = document.getElementById('adminSidebarToggle');

            function closeSidebar() {
                sidebar.classList.remove('is-open');
                overlay.classList.remove('is-open');
            }

            function openSidebar() {
                sidebar.classList.add('is-open');
                overlay.classList.add('is-open');
            }

            toggle.addEventListener('click', function () {
                if (sidebar.classList.contains('is-open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);

            // Bungkus otomatis semua tabel .admin-table yang belum punya wrapper,
            // supaya bisa discroll horizontal rapi di layar sempit (HP/tablet).
            document.querySelectorAll('table.admin-table').forEach(function (table) {
                var parent = table.parentElement;
                if (!parent || !parent.classList.contains('admin-table-wrapper')) {
                    var wrapper = document.createElement('div');
                    wrapper.className = 'admin-table-wrapper';
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            });
        })();
    </script>
</body>
</html>