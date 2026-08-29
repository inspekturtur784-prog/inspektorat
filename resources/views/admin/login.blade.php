<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Inspektorat Kota Mojokerto</title>
    <link rel="icon" href="{{ asset('images/logo-mojokerto.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-extra.css') }}">
</head>
<body style="background:var(--paper, #F5F1E6); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px;">

    <div style="width:100%; max-width:400px;">
        <div style="text-align:center; margin-bottom:28px;">
            <img src="{{ asset('images/logo-mojokerto.png') }}" alt="Logo Pemerintah Kota Mojokerto" style="height:56px; margin-bottom:12px;">
            <h1 style="font-size:20px; color:var(--navy, #0F2A4A); margin:0;">Inspektorat Kota Mojokerto</h1>
            <p style="color:var(--slate, #6b7280); font-size:14px; margin-top:4px;">Login Panel Admin</p>
        </div>

        <div style="background:#fff; border:1px solid var(--line, #E5E0D3); border-radius:14px; padding:32px;">
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

                <div style="margin-bottom:8px;">
                    <label for="password" style="display:block; font-weight:600; color:var(--navy, #0F2A4A); font-size:14px; margin-bottom:6px;">Password</label>
                    <input type="password" name="password" id="password" required
                        style="width:100%; padding:11px 14px; border:1px solid var(--line, #E5E0D3); border-radius:8px; font-size:15px;">
                </div>

                {{-- Fitur Tampilkan Password & Ingat Saya --}}
                <div style="display:flex; flex-direction:column; gap:10px; margin:14px 0 22px;">
                    <label style="display:flex; align-items:center; gap:8px; font-size:13.5px; color:var(--slate, #6b7280); cursor:pointer;">
                        <input type="checkbox" id="showPassword" style="cursor:pointer;"> Tampilkan Password
                    </label>

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
            <a href="{{ url('/') }}" style="color:var(--slate, #6b7280); font-size:13.5px; text-decoration:none;">&larr; Kembali ke Website</a>
        </p>
    </div>

    <script>
        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordInput = document.getElementById('password');
            passwordInput.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>