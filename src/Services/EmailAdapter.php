<?php
namespace Ntavelis\AuthEmail\Services;

use Ntavelis\AuthEmail\Services\Interfaces\Email;
use Illuminate\Contracts\Mail\Mailer as Mail;
use App\Mail\ActivateAccount;

class EmailAdapter implements Email {

    /**
     * Gets the instance of the Laravel's Mailer
     * @var Mail
     */
    protected $mail;
    /**
     * EmailAdapter constructor.
     * @param Mail $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail=$mail;
    }

    /**
     * @param $user
     * @param $link
     */
    public function sendTo($user, $link)
    {
        $this->mail->to($user->email)->send(new ActivateAccount($link));
    }
}