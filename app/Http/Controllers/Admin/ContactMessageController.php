<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /** Daftar pesan masuk (terbaru dulu), dengan badge jumlah belum dibaca. */
    public function index(): View
    {
        $pesan = ContactMessage::latest()->paginate(15);
        $jumlahBelumDibaca = ContactMessage::belumDibaca()->count();

        return view('admin.contact-messages.index', compact('pesan', 'jumlahBelumDibaca'));
    }

    /** Lihat detail satu pesan, otomatis ditandai sudah dibaca. */
    public function show(ContactMessage $contactMessage): View
    {
        $contactMessage->tandaiDibaca();

        return view('admin.contact-messages.show', ['pesan' => $contactMessage]);
    }

    /** Hapus pesan. */
    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('status', 'Pesan berhasil dihapus.');
    }
}