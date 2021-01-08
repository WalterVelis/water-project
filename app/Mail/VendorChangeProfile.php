<?php

namespace App\Mail;

use App\Vendor;
use Doctrine\DBAL\Types\ArrayType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorChangeProfile extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $detectedChanges)
    {
        //
        $this->detectedChanges = $detectedChanges;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendors.changeProfile')
        ->subject("Cotizador AguaH2O")
        ->with([
                'vendorName' => auth()->user()->vendor->name,
                'dataChanges' => $this->detectedChanges,
                'urlEmail' => config('app.url').'/vendor?filter=approve'
        ]);
    }
}
