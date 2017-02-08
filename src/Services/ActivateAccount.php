<?php

namespace Ntavelis\AuthEmail\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateAccount extends Mailable{

    use Queueable, SerializesModels;

    /**
     * The link for the user to confirm their account.
     * @var String
     */
    public $link;

    /**
     * Create a new message instance.
     *
     * @param String $link
     */
    public function __construct(String $link)
    {
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.name').' - Account activation.')
            ->markdown('emails.auth');
    }
}
