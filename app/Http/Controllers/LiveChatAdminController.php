<?php

namespace App\Http\Controllers;

use App\Models\LiveChatThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LiveChatAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = LiveChatThread::query()->orderByDesc('last_message_at');

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

        return view('livechat.admin.index', compact('threads'));
    }

    public function show(LiveChatThread $thread)
    {
        $thread->update(['admin_last_read_at' => now()]);
        $messages = $thread->messages;

        return view('livechat.admin.show', compact('thread', 'messages'));
    }

    // Polling dari halaman admin
    public function messages(Request $request, LiveChatThread $thread)
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

    public function reply(Request $request, LiveChatThread $thread)
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
            Log::warning('LiveChat: gagal kirim email ke pengguna - ' . $e->getMessage());
        }

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'id' => $msg->id]);
        }

        return back()->with('success', 'Balasan terkirim.');
    }

    public function close(LiveChatThread $thread)
    {
        $thread->update(['status' => 'ditutup']);

        return back()->with('success', 'Konsultasi ditutup.');
    }
}