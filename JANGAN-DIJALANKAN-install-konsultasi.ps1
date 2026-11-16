# =====================================================================
# install-konsultasi.ps1
# Fitur Konsultasi / Live Chat - Inspektorat Kota Mojokerto (Laravel)
#
# Jalankan dari ROOT proyek Laravel:
#   powershell -ExecutionPolicy Bypass -File .\install-konsultasi.ps1
#
# Skrip ini:
#   - HANYA membuat file baru (migration, model, controller, view)
#   - Menambah (append) route ke routes/web.php  -> backup .bak dibuat
#   - Menambah 1 baris @include di layouts/app.blade.php -> backup .bak dibuat
#   - Tidak mengubah/menimpa kode lama yang sudah jalan
# =====================================================================

$ErrorActionPreference = 'Stop'

if (-not (Test-Path 'artisan')) {
    Write-Host 'ERROR: jalankan skrip ini dari root proyek Laravel (folder yang ada file artisan).' -ForegroundColor Red
    exit 1
}

$utf8 = New-Object System.Text.UTF8Encoding($false)

function Write-NewFile($path, $content) {
    $dir = Split-Path $path -Parent
    if ($dir -and -not (Test-Path $dir)) { New-Item -ItemType Directory -Path $dir -Force | Out-Null }
    if (Test-Path $path) {
        Write-Host "SKIP (sudah ada): $path" -ForegroundColor Yellow
        return
    }
    [System.IO.File]::WriteAllText((Join-Path (Get-Location) $path), $content, $utf8)
    Write-Host "OK   : $path" -ForegroundColor Green
}

# ---------------------------------------------------------------------
# 1. MIGRATION
# ---------------------------------------------------------------------
$migration = @'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsultasi_threads', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon', 30)->nullable();
            $table->string('status', 20)->default('baru'); // baru | dijawab | ditutup
            $table->timestamp('last_message_at')->nullable();
            $table->timestamp('admin_last_read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('konsultasi_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_id')->constrained('konsultasi_threads')->cascadeOnDelete();
            $table->string('sender', 10); // user | admin
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi_messages');
        Schema::dropIfExists('konsultasi_threads');
    }
};
'@
Write-NewFile 'database/migrations/2026_11_09_000001_create_konsultasi_tables.php' $migration

# ---------------------------------------------------------------------
# 2. MODELS
# ---------------------------------------------------------------------
$modelThread = @'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonsultasiThread extends Model
{
    protected $table = 'konsultasi_threads';

    protected $fillable = [
        'token', 'nama', 'email', 'telepon', 'status',
        'last_message_at', 'admin_last_read_at',
    ];

    protected $casts = [
        'last_message_at'    => 'datetime',
        'admin_last_read_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(KonsultasiMessage::class, 'thread_id')->orderBy('id');
    }
}
'@
Write-NewFile 'app/Models/KonsultasiThread.php' $modelThread

$modelMessage = @'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonsultasiMessage extends Model
{
    protected $table = 'konsultasi_messages';

    protected $fillable = ['thread_id', 'sender', 'admin_id', 'body'];

    public function thread()
    {
        return $this->belongsTo(KonsultasiThread::class, 'thread_id');
    }
}
'@
Write-NewFile 'app/Models/KonsultasiMessage.php' $modelMessage

# ---------------------------------------------------------------------
# 3. CONTROLLER PUBLIK (widget di beranda)
# ---------------------------------------------------------------------
$ctrlPublic = @'
<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiMessage;
use App\Models\KonsultasiThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KonsultasiController extends Controller
{
    // Pengguna mengajukan konsultasi baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'telepon' => 'nullable|string|max:30',
            'pesan'   => 'required|string|max:2000',
        ]);

        $thread = KonsultasiThread::create([
            'token'           => Str::random(40),
            'nama'            => $data['nama'],
            'email'           => $data['email'],
            'telepon'         => $data['telepon'] ?? null,
            'status'          => 'baru',
            'last_message_at' => now(),
        ]);

        $msg = $thread->messages()->create([
            'sender' => 'user',
            'body'   => $data['pesan'],
        ]);

        $this->notifyAdmin($thread, $data['pesan'], true);

        return response()->json([
            'token'    => $thread->token,
            'messages' => [$this->fmt($msg)],
        ]);
    }

    // Polling pesan baru (dipanggil widget tiap beberapa detik)
    public function messages(Request $request, string $token)
    {
        $thread = KonsultasiThread::where('token', $token)->firstOrFail();
        $after  = (int) $request->query('after', 0);

        $items = $thread->messages()->where('id', '>', $after)->get()
            ->map(fn ($m) => $this->fmt($m))->values();

        return response()->json([
            'status'   => $thread->status,
            'messages' => $items,
        ]);
    }

    // Pengguna mengirim pesan lanjutan
    public function send(Request $request, string $token)
    {
        $thread = KonsultasiThread::where('token', $token)->firstOrFail();

        if ($thread->status === 'ditutup') {
            return response()->json(['message' => 'Konsultasi ini sudah ditutup.'], 403);
        }

        $data = $request->validate(['pesan' => 'required|string|max:2000']);

        $msg = $thread->messages()->create([
            'sender' => 'user',
            'body'   => $data['pesan'],
        ]);

        $thread->update(['status' => 'baru', 'last_message_at' => now()]);

        $this->notifyAdmin($thread, $data['pesan'], false);

        return response()->json(['message' => $this->fmt($msg)]);
    }

    private function fmt(KonsultasiMessage $m): array
    {
        return [
            'id'     => $m->id,
            'sender' => $m->sender,
            'body'   => $m->body,
            'time'   => $m->created_at->format('d/m/Y H:i'),
        ];
    }

    private function notifyAdmin(KonsultasiThread $thread, string $pesan, bool $baru): void
    {
        $to = env('KONSULTASI_ADMIN_EMAIL', config('mail.from.address'));
        if (!$to) {
            return;
        }

        $subject = ($baru ? 'Konsultasi baru' : 'Pesan baru konsultasi') . ' dari ' . $thread->nama;
        $link    = url('/admin/konsultasi/' . $thread->id);

        $text = "Halo Admin,\n\n"
              . ($baru ? "Ada konsultasi baru" : "Ada pesan lanjutan") . " di website Inspektorat.\n\n"
              . "Nama   : {$thread->nama}\n"
              . "Email  : {$thread->email}\n"
              . "Telepon: " . ($thread->telepon ?: '-') . "\n\n"
              . "Pesan:\n{$pesan}\n\n"
              . "Balas lewat dashboard: {$link}\n";

        try {
            Mail::raw($text, function ($m) use ($to, $subject, $thread) {
                $m->to($to)->subject($subject)->replyTo($thread->email, $thread->nama);
            });
        } catch (\Throwable $e) {
            // Jangan gagalkan chat jika email bermasalah; data tetap tersimpan di DB.
            Log::warning('Konsultasi: gagal kirim email admin - ' . $e->getMessage());
        }
    }
}
'@
Write-NewFile 'app/Http/Controllers/KonsultasiController.php' $ctrlPublic

# ---------------------------------------------------------------------
# 4. CONTROLLER ADMIN (dashboard)
# ---------------------------------------------------------------------
$ctrlAdmin = @'
<?php

namespace App\Http\Controllers;

use App\Models\KonsultasiThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class KonsultasiAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = KonsultasiThread::query()->orderByDesc('last_message_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $threads = $query->paginate(20)->withQueryString();

        foreach ($threads as $t) {
            $t->unread = $t->messages()
                ->where('sender', 'user')
                ->where('created_at', '>', $t->admin_last_read_at ?? '1970-01-01')
                ->count();
            $t->last_body = optional($t->messages()->latest('id')->first())->body;
        }

        return view('konsultasi.admin.index', compact('threads'));
    }

    public function show(KonsultasiThread $thread)
    {
        $thread->update(['admin_last_read_at' => now()]);
        $messages = $thread->messages;

        return view('konsultasi.admin.show', compact('thread', 'messages'));
    }

    // Polling dari halaman admin
    public function messages(Request $request, KonsultasiThread $thread)
    {
        $after = (int) $request->query('after', 0);
        $thread->update(['admin_last_read_at' => now()]);

        return response()->json([
            'status'   => $thread->status,
            'messages' => $thread->messages()->where('id', '>', $after)->get()->map(fn ($m) => [
                'id'     => $m->id,
                'sender' => $m->sender,
                'body'   => $m->body,
                'time'   => $m->created_at->format('d/m/Y H:i'),
            ])->values(),
        ]);
    }

    public function reply(Request $request, KonsultasiThread $thread)
    {
        $data = $request->validate(['pesan' => 'required|string|max:3000']);

        $msg = $thread->messages()->create([
            'sender'   => 'admin',
            'admin_id' => auth()->id(),
            'body'     => $data['pesan'],
        ]);

        $thread->update([
            'status'             => 'dijawab',
            'last_message_at'    => now(),
            'admin_last_read_at' => now(),
        ]);

        // Email pemberitahuan otomatis ke pengguna
        $text = "Yth. {$thread->nama},\n\n"
              . "Konsultasi Anda di website Inspektorat Kota Mojokerto telah dibalas oleh admin:\n\n"
              . "----------------------------------------\n"
              . $data['pesan'] . "\n"
              . "----------------------------------------\n\n"
              . "Anda dapat melanjutkan percakapan melalui jendela chat di beranda website kami.\n\n"
              . "Terima kasih,\nInspektorat Kota Mojokerto";

        try {
            Mail::raw($text, function ($m) use ($thread) {
                $m->to($thread->email, $thread->nama)
                  ->subject('Balasan konsultasi Anda - Inspektorat Kota Mojokerto');
            });
        } catch (\Throwable $e) {
            Log::warning('Konsultasi: gagal kirim email ke pengguna - ' . $e->getMessage());
        }

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'id' => $msg->id]);
        }

        return back()->with('success', 'Balasan terkirim.');
    }

    public function close(KonsultasiThread $thread)
    {
        $thread->update(['status' => 'ditutup']);

        return back()->with('success', 'Konsultasi ditutup.');
    }
}
'@
Write-NewFile 'app/Http/Controllers/KonsultasiAdminController.php' $ctrlAdmin

# ---------------------------------------------------------------------
# 5. VIEW: WIDGET LIVE CHAT (beranda, kanan bawah)
# ---------------------------------------------------------------------
$widget = @'
{{-- Widget Konsultasi / Live Chat - Inspektorat --}}
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
</style>

<button id="kns-btn" type="button" title="Konsultasi dengan Admin" aria-label="Konsultasi">&#128172;</button>

<div id="kns-box" role="dialog" aria-label="Konsultasi Inspektorat">
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
    var KEY  = 'kns_token';
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
        api('GET', '/konsultasi/' + token + '/messages?after=' + lastId).then(function (r) {
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
        api('POST', '/konsultasi', payload).then(function (r) {
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
        api('POST', '/konsultasi/' + token + '/send', { pesan: text }).then(function (r) {
            if (r.ok) addMsg(r.data.message);
            else { inp.value = text; alert((r.data && r.data.message) || 'Gagal mengirim pesan.'); }
        });
    }
    $('kns-go').onclick = sendMsg;
    $('kns-input').addEventListener('keydown', function (e) { if (e.key === 'Enter') sendMsg(); });

    // Pulihkan percakapan sebelumnya (riwayat chat pengguna)
    try { token = localStorage.getItem(KEY); } catch (e) {}
    if (token) {
        api('GET', '/konsultasi/' + token + '/messages?after=0').then(function (r) {
            if (r.ok) { r.data.messages.forEach(addMsg); showChat(); }
            else { showForm(); }
        }).catch(function () {});
    }
})();
</script>
'@
Write-NewFile 'resources/views/konsultasi/widget.blade.php' $widget

# ---------------------------------------------------------------------
# 6. VIEW ADMIN: daftar konsultasi
# ---------------------------------------------------------------------
$adminIndex = @'
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Konsultasi Masuk - Admin Inspektorat</title>
<style>
body{font-family:system-ui,Arial,sans-serif;background:#f3f5f9;margin:0;padding:24px;color:#222}
.wrap{max-width:1000px;margin:auto;background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,.08)}
h1{margin-top:0;font-size:22px}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border-bottom:1px solid #eee;text-align:left;font-size:14px;vertical-align:top}
th{background:#f7f8fb}
.badge{display:inline-block;padding:2px 8px;border-radius:10px;font-size:12px;color:#fff}
.baru{background:#dc3545}.dijawab{background:#198754}.ditutup{background:#6c757d}
.unread{background:#0d6efd;color:#fff;border-radius:10px;padding:1px 7px;font-size:12px;margin-left:4px}
a{color:#0d6efd;text-decoration:none}
.filter a{margin-right:10px}
.alert{background:#d1e7dd;padding:8px 12px;border-radius:6px;margin-bottom:12px}
</style>
</head>
<body>
<div class="wrap">
    <h1>Konsultasi Masuk</h1>
    @if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
    <p class="filter">
        <a href="{{ url('/admin/konsultasi') }}">Semua</a>
        <a href="{{ url('/admin/konsultasi?status=baru') }}">Baru</a>
        <a href="{{ url('/admin/konsultasi?status=dijawab') }}">Dijawab</a>
        <a href="{{ url('/admin/konsultasi?status=ditutup') }}">Ditutup</a>
    </p>
    <table>
        <thead><tr><th>Pengguna</th><th>Pesan terakhir</th><th>Status</th><th>Waktu</th><th></th></tr></thead>
        <tbody>
        @forelse($threads as $t)
            <tr>
                <td><b>{{ $t->nama }}</b>@if($t->unread)<span class="unread">{{ $t->unread }}</span>@endif<br>
                    <small>{{ $t->email }}@if($t->telepon) - {{ $t->telepon }}@endif</small></td>
                <td>{{ \Illuminate\Support\Str::limit($t->last_body, 80) }}</td>
                <td><span class="badge {{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                <td>{{ optional($t->last_message_at)->format('d/m/Y H:i') }}</td>
                <td><a href="{{ url('/admin/konsultasi/'.$t->id) }}">Buka</a></td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada konsultasi.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div style="margin-top:14px">{{ $threads->links() }}</div>
</div>
</body>
</html>
'@
Write-NewFile 'resources/views/konsultasi/admin/index.blade.php' $adminIndex

# ---------------------------------------------------------------------
# 7. VIEW ADMIN: detail chat + balas
# ---------------------------------------------------------------------
$adminShow = @'
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Konsultasi {{ $thread->nama }} - Admin Inspektorat</title>
<style>
body{font-family:system-ui,Arial,sans-serif;background:#f3f5f9;margin:0;padding:24px;color:#222}
.wrap{max-width:760px;margin:auto;background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,.08)}
h1{margin:0 0 4px;font-size:20px}
.info{font-size:13px;color:#555;margin-bottom:14px}
#msgs{height:380px;overflow:auto;background:#f3f5f9;border-radius:8px;padding:12px}
.m{max-width:80%;margin-bottom:10px;padding:8px 10px;border-radius:10px;white-space:pre-wrap;word-wrap:break-word}
.m.user{background:#fff;border:1px solid #dde}
.m.admin{margin-left:auto;background:#0d6efd;color:#fff}
.m small{display:block;opacity:.65;font-size:11px;margin-top:3px}
textarea{width:100%;box-sizing:border-box;border:1px solid #ccd;border-radius:8px;padding:8px;font:inherit;min-height:80px;margin-top:12px}
button,.btn{background:#0d6efd;color:#fff;border:0;border-radius:8px;padding:9px 16px;cursor:pointer;font:inherit}
.btn-grey{background:#6c757d}
.row{display:flex;justify-content:space-between;align-items:center;margin-top:8px}
a{color:#0d6efd;text-decoration:none}
.alert{background:#d1e7dd;padding:8px 12px;border-radius:6px;margin-bottom:12px}
.err{background:#f8d7da;padding:8px 12px;border-radius:6px;margin-top:8px}
</style>
</head>
<body>
<div class="wrap">
    <a href="{{ url('/admin/konsultasi') }}">&larr; Kembali ke daftar</a>
    <h1>{{ $thread->nama }}</h1>
    <div class="info">
        {{ $thread->email }}@if($thread->telepon) &middot; {{ $thread->telepon }}@endif
        &middot; Status: <b id="status">{{ ucfirst($thread->status) }}</b>
    </div>
    @if(session('success'))<div class="alert">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="err">{{ $errors->first() }}</div>@endif

    <div id="msgs">
        @foreach($messages as $m)
            <div class="m {{ $m->sender }}" data-id="{{ $m->id }}">{{ $m->body }}<small>{{ $m->sender === 'admin' ? 'Admin' : $thread->nama }} - {{ $m->created_at->format('d/m/Y H:i') }}</small></div>
        @endforeach
    </div>

    @if($thread->status !== 'ditutup')
    <form method="POST" action="{{ url('/admin/konsultasi/'.$thread->id.'/reply') }}">
        @csrf
        <textarea name="pesan" placeholder="Tulis balasan... (pengguna akan menerima email pemberitahuan)" required></textarea>
        <div class="row">
            <button type="submit">Kirim Balasan</button>
        </div>
    </form>
    <form method="POST" action="{{ url('/admin/konsultasi/'.$thread->id.'/close') }}" style="margin-top:8px" onsubmit="return confirm('Tutup konsultasi ini?')">
        @csrf
        <button type="submit" class="btn-grey">Tutup Konsultasi</button>
    </form>
    @else
        <p><i>Konsultasi ini sudah ditutup.</i></p>
    @endif
</div>

<script>
(function () {
    var box = document.getElementById('msgs');
    var last = {{ (int) optional($messages->last())->id }};
    box.scrollTop = box.scrollHeight;

    function add(m) {
        if (m.id <= last) return;
        last = m.id;
        var d = document.createElement('div');
        d.className = 'm ' + m.sender;
        d.setAttribute('data-id', m.id);
        d.textContent = m.body;
        var s = document.createElement('small');
        s.textContent = (m.sender === 'admin' ? 'Admin' : @json($thread->nama)) + ' - ' + m.time;
        d.appendChild(s);
        box.appendChild(d);
        box.scrollTop = box.scrollHeight;
    }

    setInterval(function () {
        fetch('{{ url('/admin/konsultasi/'.$thread->id.'/messages') }}?after=' + last, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function (r) { return r.json(); }).then(function (j) {
            j.messages.forEach(add);
        }).catch(function () {});
    }, 5000);
})();
</script>
</body>
</html>
'@
Write-NewFile 'resources/views/konsultasi/admin/show.blade.php' $adminShow

# ---------------------------------------------------------------------
# 8. ROUTES (append, bukan ubah)
# ---------------------------------------------------------------------
$routesPath = 'routes/web.php'
$routeMarker = '// === KONSULTASI LIVE CHAT ==='
$routesRaw = [System.IO.File]::ReadAllText((Join-Path (Get-Location) $routesPath))

if ($routesRaw -notlike "*$routeMarker*") {
    Copy-Item $routesPath "$routesPath.bak-konsultasi" -Force
    $routes = @'


// === KONSULTASI LIVE CHAT ===
Route::prefix('konsultasi')->group(function () {
    Route::post('/', [\App\Http\Controllers\KonsultasiController::class, 'store'])->middleware('throttle:5,1');
    Route::get('/{token}/messages', [\App\Http\Controllers\KonsultasiController::class, 'messages'])->middleware('throttle:60,1');
    Route::post('/{token}/send', [\App\Http\Controllers\KonsultasiController::class, 'send'])->middleware('throttle:20,1');
});

// Dashboard admin (sesuaikan middleware 'auth' dengan middleware admin yang sudah dipakai)
Route::middleware(['auth'])->prefix('admin/konsultasi')->group(function () {
    Route::get('/', [\App\Http\Controllers\KonsultasiAdminController::class, 'index']);
    Route::get('/{thread}', [\App\Http\Controllers\KonsultasiAdminController::class, 'show']);
    Route::get('/{thread}/messages', [\App\Http\Controllers\KonsultasiAdminController::class, 'messages']);
    Route::post('/{thread}/reply', [\App\Http\Controllers\KonsultasiAdminController::class, 'reply']);
    Route::post('/{thread}/close', [\App\Http\Controllers\KonsultasiAdminController::class, 'close']);
});
// === END KONSULTASI LIVE CHAT ===
'@
    [System.IO.File]::AppendAllText((Join-Path (Get-Location) $routesPath), $routes, $utf8)
    Write-Host "OK   : route ditambahkan ke $routesPath (backup: $routesPath.bak-konsultasi)" -ForegroundColor Green
} else {
    Write-Host "SKIP : route konsultasi sudah ada" -ForegroundColor Yellow
}

# ---------------------------------------------------------------------
# 9. PASANG WIDGET DI LAYOUT (hanya tampil di beranda)
# ---------------------------------------------------------------------
$layoutPath = 'resources/views/layouts/app.blade.php'
if (Test-Path $layoutPath) {
    $layout = [System.IO.File]::ReadAllText((Join-Path (Get-Location) $layoutPath))
    if ($layout -notlike "*konsultasi.widget*") {
        if ($layout -match '</body>') {
            Copy-Item $layoutPath "$layoutPath.bak-konsultasi" -Force
            $inject = "@if(request()->is('/'))`r`n    @include('konsultasi.widget')`r`n@endif`r`n</body>"
            $idx = $layout.LastIndexOf('</body>')
            $layout = $layout.Substring(0, $idx) + $inject + $layout.Substring($idx + 7)
            [System.IO.File]::WriteAllText((Join-Path (Get-Location) $layoutPath), $layout, $utf8)
            Write-Host "OK   : widget dipasang di $layoutPath (backup: $layoutPath.bak-konsultasi)" -ForegroundColor Green
        } else {
            Write-Host "PERHATIAN: tag </body> tidak ditemukan di $layoutPath. Tambahkan manual: @include('konsultasi.widget')" -ForegroundColor Yellow
        }
    } else {
        Write-Host "SKIP : widget sudah terpasang di layout" -ForegroundColor Yellow
    }
} else {
    Write-Host "PERHATIAN: $layoutPath tidak ditemukan. Tambahkan manual: @include('konsultasi.widget')" -ForegroundColor Yellow
}

# ---------------------------------------------------------------------
Write-Host ''
Write-Host 'SELESAI. Langkah berikutnya:' -ForegroundColor Cyan
Write-Host '  1. Isi .env:  KONSULTASI_ADMIN_EMAIL=email-admin@contoh.go.id  + setting MAIL_* (SMTP)'
Write-Host '  2. php artisan migrate'
Write-Host '  3. php artisan config:clear ; php artisan route:clear ; php artisan view:clear'
Write-Host '  4. Buka beranda -> ikon chat kanan bawah. Dashboard admin: /admin/konsultasi'
