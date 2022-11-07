<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $user_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $user_id)
    {
        $this->user = $user;
        $this->user_id = $user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newUser')->with('user', $this->user)->with('user_id', $this->user_id);
    }
}
