<?php

namespace App\Mail;

use App\Vendor;
use App\VendorNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorReviewProfile extends Mailable
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
        //$this->user->email,
        $message = '';
        $statusApproved = true;
        if($this->vendor->status == '3'){
            $message = __(', you are now ready to work along IIASA');            
        }else{
            $message = __(', please check the comments, adjust your information accordingly and submit it for review');
            $statusApproved = false;
        }        
        return $this->markdown('emails.vendors.reviewProfile')
        ->subject(__('Review Completed'))
        ->with([
                'text_msj1' => __('Your profile has been'),
                'text_msj2' => $message,
                'vendorId' => $this->vendor->id,                
                'revision_number' => $this->vendor->revision_number,
                'statusVendor' => $this->vendor->status,
                'statusApproved' => $statusApproved,
                'urlEmail' => config('app.url').'/vendor/'.$this->vendor->id.'/edit'
        ]);
    }
}
