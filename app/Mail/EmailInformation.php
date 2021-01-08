<?php

namespace App\Mail;

use App\Role;
use App\User;
use App\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailInformation extends Mailable
{
    use Queueable, SerializesModels;


    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
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
        if($this->user->role->name == 'Vendor'){
            //
            return $this->markdown('emails.users.information')
            ->subject("Cotizador AguaH2O")
            ->with([
                'email' => $this->user->email,
                'password' => $this->user->password,
                'typeRol' => true,
                'userRole' => $this->user->role->name
            ]);
        }else{
            return $this->markdown('emails.users.information')
            ->subject("Cotizador AguaH2O")
            ->with([
                'email' => $this->user->email,
                'password' => $this->user->password,
                'typeRol' => false,
                'userRole' => $this->user->role->name
            ]);
        }
    }
}
