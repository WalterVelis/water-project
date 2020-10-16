<?php

namespace App\Mail;

use App\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorRemindVendor extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Vendor $vendor)
    {
        //
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendors.remindVendor')
        ->subject(__('Remind Vendor'))
        ->with([
                'text_msj' => __('We invite you to enter our site, complete your vendor profile and submit it for review'),
                'vendorName' => $this->vendor->name,
                'urlEmail' => config('app.url').'/vendor/'.$this->vendor->id.'/edit'
        ]);
    }
}
