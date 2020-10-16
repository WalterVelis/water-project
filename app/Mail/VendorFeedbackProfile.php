<?php

namespace App\Mail;

use App\Vendor;
use App\VendorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorFeedbackProfile extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VendorNotification $notify, Vendor $vendor)
    {
        //
        $this->notify = $notify;
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendors.feedbackProfile')
        ->subject(__('Feedback on vendor profile'))
        ->with([
                'text_msj' => __('A reviewer has made comments in your profile. Your profile won’t be available for edit until every reviewer has reviewed it.'),
                'feedback' => $this->notify->motive,
                'urlEmail' => config('app.url').'/vendor/'.$this->vendor->id.'/edit'
        ]);
    }
}
