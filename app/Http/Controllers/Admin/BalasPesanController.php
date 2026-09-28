<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BalasanPesan;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BalasPesanController extends Controller
{
    public function kirim(Request $request, Pesan $pesan)
    {
        $request->validate([
            'balasan' => 'required|string|min:3',
        ]);

        try {
            Mail::to($pesan->email)->send(new BalasanPesan($pesan, $request->balasan));
        } catch (\Throwable $e) {
            report($e);
            return back()
                ->withInput()
                ->with('balas_error', 'Email gagal dikirim. Periksa pengaturan SMTP di .env');
        }

        $pesan->forceFill([
            'balasan'      => $request->balasan,
            'dibalas_pada' => now(),
        ])->save();

        return back()->with('balas_status', 'Balasan berhasil dikirim ke ' . $pesan->email);
    }
}