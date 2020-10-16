<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorRemindReviewers extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $vendor)
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
        return $this->markdown('emails.vendors.remindReviewers')
        ->subject(__('Remind Reviewer'))
        ->with([
                'text_msj1' => __('The profile of the vendor '),
                'text_msj2' => __(' is awaiting for your review. Click the button to review his/her profile'),
                'vendorName' => $this->vendor,
                'urlEmail' => config('app.url').'/vendor#approve'
        ]);
    }
}
