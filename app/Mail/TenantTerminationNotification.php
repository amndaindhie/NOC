<?php

namespace App\Mail;

use App\Models\NocTermination;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantTerminationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $termination;

    /**
     * Create a new message instance.
     *
     * @param NocTermination $termination
     * @return void
     */
    public function __construct(NocTermination $termination)
    {
        $this->termination = $termination;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notifikasi Pengajuan Terminasi - ' . $this->termination->nomor_tiket)
                    ->view('emails.tenant-termination-notification');
    }
}
