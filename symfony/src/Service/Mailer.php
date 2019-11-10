<?php

namespace App\Service;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;
    /**
     * @var \Twig\Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig\Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send(
        string $to,
        string $subject,
        string $view,
        array $params = [],
        string $from = 'local.app@domain.com'
    ) {
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $this->twig->render(
                    $view,
                    $params
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
