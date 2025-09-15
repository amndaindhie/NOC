<?php

namespace App\Mail;

use App\Models\NocComplaint;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantComplaintNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;

    /**
     * Create a new message instance.
     *
     * @param NocComplaint $complaint
     * @return void
     */
    public function __construct(NocComplaint $complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notifikasi Pengajuan Keluhan - ' . $this->complaint->nomor_tiket)
                    ->view('emails.tenant-complaint-notification');
    }
}
