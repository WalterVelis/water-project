<?php

namespace App\Mail;

use App\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorProfileComplete extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $user)
    {
        //
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendors.profileComplete')
        ->subject(__('Complete vendor profile'))
        ->with([
                'text_msj' => 'The vendor :actionText has completed its profile and has submitted it for review. Click on the button for review it.',
                'vendorName' => auth()->user()->vendor->name,
                'urlEmail' => config('app.url').'/vendor?filter=approve'
        ]);
    }
}
