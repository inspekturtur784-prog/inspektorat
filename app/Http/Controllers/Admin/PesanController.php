<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;

class PesanController extends Controller
{
    public function index()
    {
        $pesans = Pesan::terbaru()->paginate(15);
        return view('admin.pesan.index', compact('pesans'));
    }

    public function show(Pesan $pesan)
    {
        if (! $pesan->is_read) {
            $pesan->update(['is_read' => true]);
        }

        return view('admin.pesan.show', compact('pesan'));
    }

    public function destroy(Pesan $pesan)
    {
        $pesan->delete();
        return redirect()->route('admin.pesan.index')->with('status', 'Pesan berhasil dihapus.');
    }
}