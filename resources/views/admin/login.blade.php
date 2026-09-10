<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Inspektorat Kota Mojokerto</title>
    <link rel="icon" href="{{ asset('images/logo-mojokerto.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-extra.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            background-color: #071a33;
        }

        /* Layer foto background */
        .bg-image-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            z-index: 1;
        }

        /* Overlay transparan */
        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(7, 26, 51, 0.45);
            z-index: 2;
        }

        /* Container login */
        .login-wrapper {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 3;
        }

        .brand-title {
            font-size: 20px;
            color: #ffffff !important;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.6);
        }

        .brand-subtitle {
            color: #e2e8f0 !important;
            font-size: 14px;
            margin-top: 4px;
        }

        .back-link {
            color: #ffffff !important;
            font-size: 13.5px;
            text-decoration: none;
            text-shadow: 0 1px 3px rgba(0,0,0,0.6);
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Wrapper Password & Ikon Mata */
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-container input {
            width: 100%;
            padding: 11px 40px 11px 14px;
            border: 1px solid var(--line, #E5E0D3);
            border-radius: 8px;
            font-size: 15px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }

        .toggle-password:hover {
            color: var(--navy, #0F2A4A);
        }
    </style>
</head>
<body>

    <div class="bg-image-layer" style="background-image: url('{{ asset('images/alun-alun.jpg') }}');"></div>
    <div class="bg-overlay"></div>

    <div class="login-wrapper">
        <div style="text-align:center; margin-bottom:28px;">
            <img src="{{ asset('images/logo-mojokerto.png') }}" alt="Logo Pemerintah Kota Mojokerto" style="height:56px; margin-bottom:12px;">
            <h1 class="brand-title">Inspektorat Kota Mojokerto</h1>
            <p class="brand-subtitle">Login Panel Admin</p>
        </div>

        <div style="background:#fff; border:1px solid var(--line, #E5E0D3); border-radius:14px; padding:32px; box-shadow: 0 10px 25px rgba(0,0,0,0.25);">
            @if ($errors->any())
                <div style="background:#FDECEA; color:#B3261E; border-radius:8px; padding:12px 16px; margin-bottom:20px; font-size:14px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div style="margin-bottom:18px;">
                    <label for="email" style="display:block; font-weight:600; color:var(--navy, #0F2A4A); font-size:14px; margin-bottom:6px;">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        style="width:100%; padding:11px 14px; border:1px solid var(--line, #E5E0D3); border-radius:8px; font-size:15px;">
                </div>

                <div style="margin-bottom:14px;">
                    <label for="password" style="display:block; font-weight:600; color:var(--navy, #0F2A4A); font-size:14px; margin-bottom:6px;">Password</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" required>
                        <button type="button" id="togglePassword" class="toggle-password" aria-label="Tampilkan Password">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <div style="margin:14px 0 22px;">
                    <label style="display:flex; align-items:center; gap:8px; font-size:13.5px; color:var(--slate, #6b7280); cursor:pointer;">
                        <input type="checkbox" name="remember" style="cursor:pointer;"> Ingat saya
                    </label>
                </div>

                <button type="submit"
                    style="width:100%; padding:12px; background:var(--navy, #0F2A4A); color:#fff; border:0; border-radius:8px; font-weight:600; font-size:15px; cursor:pointer;">
                    Masuk
                </button>
            </form>
        </div>

        <p style="text-align:center; margin-top:20px;">
            <a href="{{ url('/') }}" class="back-link">&larr; Kembali ke Website</a>
        </p>
    </div>

    <script>
        const togglePasswordBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePasswordBtn.addEventListener('click', function() {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            if (isPassword) {
                // SVG Mata Coret (Hide)
                eyeIcon.innerHTML = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>`;
            } else {
                // SVG Mata Terbuka (Show)
                eyeIcon.innerHTML = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>`;
            }
        });
    </script>
</body>
</html>