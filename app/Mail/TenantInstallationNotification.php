<?php

namespace App\Mail;

use App\Models\NocInstallationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantInstallationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $instalasi;

    /**
     * Create a new message instance.
     *
     * @param NocInstallationRequest $instalasi
     * @return void
     */
    public function __construct(NocInstallationRequest $instalasi)
    {
        $this->instalasi = $instalasi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notifikasi Pengajuan Instalasi - ' . $this->instalasi->nomor_tiket)
                    ->view('emails.tenant-instalasi-notification');
    }
}
