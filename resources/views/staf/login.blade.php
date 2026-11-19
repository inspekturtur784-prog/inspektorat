<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staf - KMS Inspektorat</title>
    <link rel="icon" href="{{ asset('images/logo-mojokerto.png') }}">
    <style>
        * { box-sizing: border-box; }
        body { margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; background:#06182E; font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif; }
        .box { width:100%; max-width:400px; }
        .head { text-align:center; margin-bottom:24px; color:#fff; }
        .head img { height:56px; margin-bottom:12px; }
        .head small { display:block; font-size:12px; letter-spacing:.12em; text-transform:uppercase; color:#B08D57; }
        .head h1 { margin:6px 0 0; font-size:20px; font-weight:600; }
        .card { background:#fff; border-radius:12px; padding:28px; box-shadow:0 10px 25px rgba(0,0,0,.3); }
        label { display:block; font-weight:600; font-size:14px; color:#0B2A4A; margin-bottom:6px; }
        input[type=text], input[type=password] { width:100%; padding:11px 14px; border:1px solid #d6d9dc; border-radius:8px; font-size:15px; margin-bottom:16px; }
        .opsi { display:flex; align-items:center; gap:8px; font-size:13.5px; color:#555; margin:0 0 18px; font-weight:400; }
        button { width:100%; padding:12px; background:#0B2A4A; color:#fff; border:0; border-radius:8px; font-weight:600; font-size:15px; cursor:pointer; }
        button:hover { background:#06182E; }
        .err { background:#FDECEA; color:#B3261E; border-radius:8px; padding:12px 16px; margin-bottom:18px; font-size:14px; }
        .kembali { text-align:center; margin-top:18px; }
        .kembali a { color:#fff; font-size:13.5px; text-decoration:none; }
        .kembali a:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <div class="box">
        <div class="head">
            <img src="{{ asset('images/logo-inspektorat.png') }}" alt="Logo Inspektorat">
            <small>Inspektorat Kota Mojokerto</small>
            <h1>Login Staf</h1>
        </div>
        <div class="card">
            @if ($errors->any())
                <div class="err">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('staf.login.submit') }}">
                @csrf
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus autocomplete="username">

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required autocomplete="current-password">

                <label class="opsi"><input type="checkbox" id="lihat"> Tampilkan password</label>

                <button type="submit">Masuk</button>
            </form>
        </div>
        <p class="kembali"><a href="{{ route('kms.index') }}">&larr; Kembali ke KMS</a></p>
    </div>
    <script>
        document.getElementById('lihat').addEventListener('change', function () {
            document.getElementById('password').type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>