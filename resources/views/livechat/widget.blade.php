{{-- Widget Live Chat - Inspektorat --}}
<style>
#kns-btn{position:fixed;right:20px;bottom:20px;z-index:9998;width:60px;height:60px;border-radius:50%;border:0;background:#0d6efd;color:#fff;font-size:26px;cursor:pointer;box-shadow:0 4px 14px rgba(0,0,0,.3)}
#kns-box{position:fixed;right:20px;bottom:90px;z-index:9999;width:350px;max-width:calc(100vw - 30px);height:480px;max-height:calc(100vh - 110px);background:#fff;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,.3);display:none;flex-direction:column;overflow:hidden;font-family:system-ui,Arial,sans-serif;font-size:14px}
#kns-box.open{display:flex}
#kns-head{background:#0d6efd;color:#fff;padding:12px 14px;display:flex;justify-content:space-between;align-items:center}
#kns-head b{font-size:15px}
#kns-head small{display:block;opacity:.85;font-size:12px}
#kns-x{background:none;border:0;color:#fff;font-size:22px;cursor:pointer;line-height:1}
#kns-form,#kns-chat{flex:1;display:flex;flex-direction:column;min-height:0}
#kns-form{padding:14px;overflow:auto;gap:8px}
#kns-form input,#kns-form textarea,#kns-input{border:1px solid #ccd;border-radius:8px;padding:8px;font:inherit;width:100%;box-sizing:border-box}
#kns-form textarea{resize:vertical;min-height:80px}
.kns-primary{background:#0d6efd;color:#fff;border:0;border-radius:8px;padding:9px 14px;cursor:pointer;font:inherit}
.kns-primary:disabled{opacity:.6}
#kns-msgs{flex:1;overflow:auto;padding:12px;background:#f3f5f9}
.kns-m{max-width:82%;margin-bottom:10px;padding:8px 10px;border-radius:10px;word-wrap:break-word;white-space:pre-wrap}
.kns-m.user{margin-left:auto;background:#0d6efd;color:#fff;border-bottom-right-radius:2px}
.kns-m.admin{background:#fff;border:1px solid #dde;border-bottom-left-radius:2px}
.kns-m small{display:block;opacity:.65;font-size:11px;margin-top:3px}
#kns-send{display:flex;gap:6px;padding:8px;border-top:1px solid #e3e6ee}
#kns-err{color:#c00;font-size:12px;min-height:14px}
#kns-reset{background:none;border:0;color:#fff;font-size:12px;text-decoration:underline;cursor:pointer;padding:0}
/* LIVECHAT-KARTU */
@media (min-width: 992px) { .produk-grid { grid-template-columns: repeat(4, 1fr); } }</style>

<button id="kns-btn" type="button" title="Konsultasi dengan Admin" aria-label="Konsultasi">&#128172;</button>

<div id="kns-box" role="dialog" aria-label="Live Chat Inspektorat">
    <div id="kns-head">
        <div><b>Konsultasi Inspektorat</b><small>Admin akan membalas secepatnya</small></div>
        <div><button id="kns-reset" type="button" style="display:none">Konsultasi baru</button> <button id="kns-x" type="button" aria-label="Tutup">&times;</button></div>
    </div>

    <div id="kns-form">
        <input id="kns-nama" placeholder="Nama lengkap *" maxlength="100">
        <input id="kns-email" type="email" placeholder="Email aktif * (untuk notifikasi balasan)" maxlength="150">
        <input id="kns-telp" placeholder="No. telepon (opsional)" maxlength="30">
        <textarea id="kns-pesan" placeholder="Tulis pertanyaan / konsultasi Anda *" maxlength="2000"></textarea>
        <div id="kns-err"></div>
        <button id="kns-submit" class="kns-primary" type="button">Kirim Konsultasi</button>
    </div>

    <div id="kns-chat" style="display:none">
        <div id="kns-msgs"></div>
        <div id="kns-send">
            <input id="kns-input" placeholder="Tulis pesan..." maxlength="2000">
            <button id="kns-go" class="kns-primary" type="button">Kirim</button>
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
        d.className = 'kns-m ' + m.sender;
        d.textContent = m.body;                       // aman dari XSS
        var s = document.createElement('small');
        s.textContent = (m.sender === 'admin' ? 'Admin' : 'Anda') + ' - ' + m.time;
        d.appendChild(s);
        var box = $('kns-msgs');
        box.appendChild(d);
        box.scrollTop = box.scrollHeight;
    }

    function showChat() {
        $('kns-form').style.display = 'none';
        $('kns-chat').style.display = 'flex';
        $('kns-reset').style.display = 'inline';
        if (timer) clearInterval(timer);
        timer = setInterval(poll, 5000);
    }

    function showForm() {
        if (timer) clearInterval(timer);
        token = null; lastId = 0;
        try { localStorage.removeItem(KEY); } catch (e) {}
        $('kns-msgs').innerHTML = '';
        $('kns-chat').style.display = 'none';
        $('kns-form').style.display = 'flex';
        $('kns-reset').style.display = 'none';
    }

    function poll() {
        if (!token || !$('kns-box').classList.contains('open')) return;
        api('GET', BASE + '/' + token + '/messages?after=' + lastId).then(function (r) {
            if (r.status === 404) { showForm(); return; }
            if (r.ok) r.data.messages.forEach(addMsg);
        }).catch(function () {});
    }

    $('kns-btn').onclick = function () {
        $('kns-box').classList.toggle('open');
        if ($('kns-box').classList.contains('open') && token) poll();
    };
    $('kns-x').onclick = function () { $('kns-box').classList.remove('open'); };
    $('kns-reset').onclick = showForm;

    $('kns-submit').onclick = function () {
        var btn = $('kns-submit'), err = $('kns-err');
        err.textContent = '';
        var payload = {
            nama: $('kns-nama').value.trim(),
            email: $('kns-email').value.trim(),
            telepon: $('kns-telp').value.trim(),
            pesan: $('kns-pesan').value.trim()
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
            $('kns-pesan').value = '';
            showChat();
        }).catch(function () { btn.disabled = false; err.textContent = 'Koneksi bermasalah.'; });
    };

    function sendMsg() {
        var inp = $('kns-input'), text = inp.value.trim();
        if (!text || !token) return;
        inp.value = '';
        api('POST', BASE + '/' + token + '/send', { pesan: text }).then(function (r) {
            if (r.ok) addMsg(r.data.message);
            else { inp.value = text; alert((r.data && r.data.message) || 'Gagal mengirim pesan.'); }
        });
    }
    $('kns-go').onclick = sendMsg;
    $('kns-input').addEventListener('keydown', function (e) { if (e.key === 'Enter') sendMsg(); });

    // Kartu "Live Chat" di bagian Layanan membuka jendela chat
    var kartuChat = document.querySelectorAll('a[href="#live-chat"]');
    if (kartuChat.length) {
        $('kns-btn').style.display = 'none';
        $('kns-box').style.bottom = '20px';
        kartuChat.forEach(function (a) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                $('kns-box').classList.add('open');
                if (token) poll();
            });
        });
    }
    // Pulihkan percakapan sebelumnya (riwayat chat pengguna)
    try { token = localStorage.getItem(KEY); } catch (e) {}
    if (token) {
        api('GET', BASE + '/' + token + '/messages?after=0').then(function (r) {
            if (r.ok) { r.data.messages.forEach(addMsg); showChat(); }
            else { showForm(); }
        }).catch(function () {});
    }
})();
</script>