<?php

namespace App\Notification;

use App\Entity\User;
use Twig\Environment;

class RegistrationNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;
    private $serverHost;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {

        $this->mailer = $mailer;
        $this->renderer = $renderer;
        $this->serverHost = $_SERVER['HTTP_HOST'];

    }

    public function notify(User $user)
    {
        $message = (new \Swift_Message('Confirmation inscription ' . $user->getName() . ' sur JimmySweat.com'))
            ->setFrom('jimmysweat@admin.com')
            ->setTo($user->getEmail())
            ->setBody($this->renderer->render('emails/confirmRegistration.html.twig', [
                'user' => $user,
                'host' => $this->serverHost
            ]), 'text/html');
        $this->mailer->send($message);
    }
}