<?php

namespace App\Http\Controllers;

use App\Models\LiveChatMessage;
use App\Models\LiveChatThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LiveChatController extends Controller
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

        $thread = LiveChatThread::create([
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
        $thread = LiveChatThread::where('token', $token)->firstOrFail();
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
        $thread = LiveChatThread::where('token', $token)->firstOrFail();

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

    private function fmt(LiveChatMessage $m): array
    {
        return [
            'id'     => $m->id,
            'sender' => $m->sender,
            'body'   => $m->body,
            'time'   => $m->created_at->format('d/m/Y H:i'),
        ];
    }

    private function notifyAdmin(LiveChatThread $thread, string $pesan, bool $baru): void
    {
        $to = env('KONSULTASI_ADMIN_EMAIL', config('mail.from.address'));
        if (!$to) {
            return;
        }

        $subject = ($baru ? 'Live chat baru' : 'Pesan baru live chat') . ' dari ' . $thread->nama;
        $link    = url('/admin/live-chat/' . $thread->id);

        $text = "Halo Admin,\n\n"
              . ($baru ? "Ada konsultasi baru" : "Ada pesan lanjutan") . " di live chat website Inspektorat.\n\n"
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
            Log::warning('LiveChat: gagal kirim email admin - ' . $e->getMessage());
        }
    }
}