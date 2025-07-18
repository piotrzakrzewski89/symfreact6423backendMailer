<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SymfonyMailerSender implements EmailSenderInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $recipient, string $subject, string $body): void
    {
        $email = (new Email())
            ->from('no-reply@example.com')
            ->to($recipient)
            ->subject($subject)
            ->html($body);

        $this->mailer->send($email);
    }
}
