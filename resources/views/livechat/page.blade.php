@extends('layouts.app')
@section('title', 'Live Chat - Inspektorat Kota Mojokerto')

@section('content')
<style>
    .konsultasi-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 60px 24px 80px;
    }

    .konsultasi-header {
        text-align: center;
        margin-bottom: 45px;
    }

    .konsultasi-label {
        color: #c89b3c;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .konsultasi-header h1 {
        color: #0f2d4f;
        font-size: 42px;
        margin: 0 0 15px;
        font-weight: 700;
    }

    .konsultasi-header p {
        color: #667085;
        font-size: 17px;
        margin: 0;
    }

    .konsultasi-options {
        display: flex;
        justify-content: center;
        margin-bottom: 55px;
    }

    .konsultasi-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(15, 45, 79, 0.06);
        max-width: 420px;
        width: 100%;
    }

    .konsultasi-card h2 {
        color: #0f2d4f;
        font-size: 22px;
        margin: 0 0 12px;
    }

    .konsultasi-card p {
        color: #667085;
        line-height: 1.7;
        margin-bottom: 24px;
    }

    .btn-konsultasi {
        display: inline-block;
        padding: 13px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        transition: 0.2s;
    }

    .btn-whatsapp {
        background: #168c4a;
        color: white;
    }

    .btn-whatsapp:hover {
        background: #11743c;
    }

    @media (max-width: 700px) {
        .konsultasi-page {
            padding: 40px 18px 60px;
        }

        .konsultasi-header h1 {
            font-size: 32px;
        }
    }
</style>
<style>
.konsultasi-card.lcp-card{max-width:560px;width:100%;text-align:left;padding:28px;box-sizing:border-box}
.lcp-card h2,.lcp-card > div > p{text-align:center}
#lcp-form{display:flex;flex-direction:column;gap:10px}
#lcp-form input,#lcp-form textarea,#lcp-input{border:1px solid #cfd6e0;border-radius:10px;padding:11px 12px;font:inherit;width:100%;box-sizing:border-box;background:#fff}
#lcp-form textarea{min-height:100px;resize:vertical}
.lcp-btn{background:var(--navy,#0b2545);color:#fff;border:0;border-radius:10px;padding:12px 18px;font:inherit;font-weight:600;cursor:pointer}
.lcp-btn:disabled{opacity:.6;cursor:default}
#lcp-err{color:#c00;font-size:13px;min-height:16px}
#lcp-msgs{height:340px;overflow:auto;background:#f3f5f9;border-radius:12px;padding:14px;border:1px solid #e3e6ee}
.lcp-m{max-width:80%;margin-bottom:10px;padding:9px 12px;border-radius:12px;white-space:pre-wrap;word-wrap:break-word;line-height:1.5;font-size:15px}
.lcp-m.user{margin-left:auto;background:var(--navy,#0b2545);color:#fff;border-bottom-right-radius:3px}
.lcp-m.admin{background:#fff;border:1px solid #dde3ec;border-bottom-left-radius:3px}
.lcp-m small{display:block;opacity:.65;font-size:11px;margin-top:4px}
.lcp-send{display:flex;gap:8px;margin-top:12px}
.lcp-send input{flex:1}
.lcp-link{background:none;border:0;color:#6b7280;text-decoration:underline;cursor:pointer;margin-top:12px;font:inherit;font-size:13px}
</style>

<div class="konsultasi-page">

    <div class="konsultasi-header">
        <div class="konsultasi-label">Layanan Inspektorat</div>
        <h1>Live Chat</h1>
        <p>Tanya langsung ke admin Inspektorat. Balasan juga dikirim ke email Anda.</p>
    </div>

    <div class="konsultasi-options">
        <div class="konsultasi-card lcp-card">
            <div id="lcp-form">
                <h2>Chat dengan Admin</h2>
                <input id="lcp-nama" placeholder="Nama lengkap *" maxlength="100">
                <input id="lcp-email" type="email" placeholder="Email aktif * (untuk notifikasi balasan)" maxlength="150">
                <input id="lcp-telp" placeholder="No. telepon (opsional)" maxlength="30">
                <textarea id="lcp-pesan" placeholder="Tulis pertanyaan atau konsultasi Anda *" maxlength="2000"></textarea>
                <div id="lcp-err"></div>
                <button id="lcp-submit" class="lcp-btn" type="button">Kirim &amp; Mulai Chat</button>
            </div>

            <div id="lcp-chat" style="display:none">
                <div id="lcp-msgs"></div>
                <div class="lcp-send">
                    <input id="lcp-input" placeholder="Tulis pesan..." maxlength="2000">
                    <button id="lcp-go" class="lcp-btn" type="button">Kirim</button>
                </div>
                <button id="lcp-reset" type="button" class="lcp-link">Mulai konsultasi baru</button>
            </div>
        </div>
    </div>

</div>

<script>
(function () {
    var CSRF = '{{ csrf_token() }}';
    var BASE = '{{ url('/live-chat') }}';
    var KEY  = 'lc_token';
    var $ = function (id) { return document.getElementById(id); };
    var token = null, lastId = 0, timer = null;

    function api(method, url, body) {
        return fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: body ? JSON.stringify(body) : undefined
        }).then(function (r) {
            return r.json().then(function (j) { return { ok: r.ok, status: r.status, data: j }; });
        });
    }

    function addMsg(m) {
        if (m.id <= lastId) return;
        lastId = m.id;
        var d = document.createElement('div');
        d.className = 'lcp-m ' + m.sender;
        d.textContent = m.body;
        var s = document.createElement('small');
        s.textContent = (m.sender === 'admin' ? 'Admin' : 'Anda') + ' - ' + m.time;
        d.appendChild(s);
        var box = $('lcp-msgs');
        box.appendChild(d);
        box.scrollTop = box.scrollHeight;
    }

    function showChat() {
        $('lcp-form').style.display = 'none';
        $('lcp-chat').style.display = 'block';
        if (timer) clearInterval(timer);
        timer = setInterval(poll, 5000);
    }

    function showForm() {
        if (timer) clearInterval(timer);
        token = null; lastId = 0;
        try { localStorage.removeItem(KEY); } catch (e) {}
        $('lcp-msgs').innerHTML = '';
        $('lcp-chat').style.display = 'none';
        $('lcp-form').style.display = 'flex';
    }

    function poll() {
        if (!token) return;
        api('GET', BASE + '/' + token + '/messages?after=' + lastId).then(function (r) {
            if (r.status === 404) { showForm(); return; }
            if (r.ok) r.data.messages.forEach(addMsg);
        }).catch(function () {});
    }

    $('lcp-submit').onclick = function () {
        var btn = $('lcp-submit'), err = $('lcp-err');
        err.textContent = '';
        var payload = {
            nama: $('lcp-nama').value.trim(),
            email: $('lcp-email').value.trim(),
            telepon: $('lcp-telp').value.trim(),
            pesan: $('lcp-pesan').value.trim()
        };
        if (!payload.nama || !payload.email || !payload.pesan) {
            err.textContent = 'Nama, email, dan pesan wajib diisi.'; return;
        }
        btn.disabled = true;
        api('POST', BASE, payload).then(function (r) {
            btn.disabled = false;
            if (!r.ok) {
                err.textContent = (r.data && r.data.message) ? r.data.message : 'Gagal mengirim. Periksa isian Anda.';
                return;
            }
            token = r.data.token;
            try { localStorage.setItem(KEY, token); } catch (e) {}
            r.data.messages.forEach(addMsg);
            $('lcp-pesan').value = '';
            showChat();
        }).catch(function () { btn.disabled = false; err.textContent = 'Koneksi bermasalah.'; });
    };

    function sendMsg() {
        var inp = $('lcp-input'), text = inp.value.trim();
        if (!text || !token) return;
        inp.value = '';
        api('POST', BASE + '/' + token + '/send', { pesan: text }).then(function (r) {
            if (r.ok) addMsg(r.data.message);
            else { inp.value = text; alert((r.data && r.data.message) || 'Gagal mengirim pesan.'); }
        });
    }
    $('lcp-go').onclick = sendMsg;
    $('lcp-input').addEventListener('keydown', function (e) { if (e.key === 'Enter') sendMsg(); });
    $('lcp-reset').onclick = showForm;

    try { token = localStorage.getItem(KEY); } catch (e) {}
    if (token) {
        api('GET', BASE + '/' + token + '/messages?after=0').then(function (r) {
            if (r.ok) { r.data.messages.forEach(addMsg); showChat(); }
            else { showForm(); }
        }).catch(function () {});
    }
})();
</script>
@endsection