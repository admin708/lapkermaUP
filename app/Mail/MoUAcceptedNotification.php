<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MoUAcceptedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct($name)
    {
        $this->user = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('MoU Request Accepted - Collect Your Hardcopy')
            ->view('email.mou_accepted_notification')
            ->with([
                'name' => $this->user,
                'floor' => '6th floor of the Directorate of Partnership',
            ]);
    }
}
