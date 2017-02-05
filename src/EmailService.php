<?php

namespace Ntavelis\AuthEmail;

use App\User;
use Ntavelis\AuthEmail\Repository\Activation;
use Ntavelis\AuthEmail\Repository\ActivationInterface;
use Ntavelis\AuthEmail\Services\Interfaces\Email;

/**
 * Class ActivationService
 * @package App
 */
class EmailService {

    /**
     * Instance of the class that implements Activation Interface
     * @var Activation
     */
    protected $activationRepo;

    /**
     * Hours to pass before resending is possible.
     * @var int
     */
    protected $resendAfter = 6;

    /**
     * Gets the instance of the class that implements Email interface
     * @var Email
     */
    protected $mailer;

    /**
     * ActivationService constructor.
     * @param ActivationInterface $activationRepo
     * @param Email $mailer
     */
    public function __construct(ActivationInterface $activationRepo, Email $mailer)
    {
        $this->activationRepo = $activationRepo;
        $this->mailer = $mailer;
    }

    /**
     * Sends activation mail.
     * @param $user
     */
    public function sendActivationMail($user)
    {

        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        $link = route('user.activate', $token);

        $this->mailer->sendTo($user, $link);
    }

    /**
     * Activates the user.
     * @param $token
     * @return mixed|null
     */
    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);

        $user->activated = true;

        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;

    }

    /**
     * Calculate when it is appropriate to resend the activation mail.
     * @param $user
     * @return bool
     */
    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);

        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}