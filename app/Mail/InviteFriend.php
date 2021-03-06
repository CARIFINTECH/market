<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteFriend extends Mailable
{
    use Queueable, SerializesModels;
    public $referral_code = "1211232";
    public $name = "xyz";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitation to join '.env('APP_NAME').'! from '.$this->name)->markdown('emails.accounts.invite',['url'=>env('APP_URL').'/register?code='.$this->referral_code,'code'=>$this->referral_code]);
    }
}
