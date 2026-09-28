<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BalasanPesan extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $pesan, public string $balasan) {}

    public function build()
    {
        return $this->subject('Balasan dari Inspektorat Kota Mojokerto')
                    ->view('emails.balasan');
    }
}