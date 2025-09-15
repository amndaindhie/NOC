<?php

namespace App\Mail;

use App\Models\NocMaintenanceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantMaintenanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $maintenance;

    /**
     * Create a new message instance.
     *
     * @param NocMaintenanceRequest $maintenance
     * @return void
     */
    public function __construct(NocMaintenanceRequest $maintenance)
    {
        $this->maintenance = $maintenance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notifikasi Pengajuan Maintenance - ' . $this->maintenance->nomor_tracking)
                    ->view('emails.tenant-maintenance-notification');
    }
}
