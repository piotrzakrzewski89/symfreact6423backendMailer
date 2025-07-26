<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Message\SendMailMessage;
use App\Domain\Entity\SendEmail;
use App\Domain\Repository\SendEmailRepository;
use App\Infrastructure\Service\EmailSenderInterface;
use DateTimeImmutable;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendEmailHandler
{
    public function __construct(
        private EmailSenderInterface $emailSender,
        private SendEmailRepository $repository
    ) {}

    public function __invoke(SendMailMessage $message): void
    {
        $email = new SendEmail();
        $email->setRecipient($message->recipient);
        $email->setSubject($message->subject);
        $email->setBody($message->body);
        $email->setSentAt(new DateTimeImmutable());

        try {
            $this->emailSender->send($message->recipient, $message->subject, $message->body);
            $email->setStatus('sent');
        } catch (\Throwable $e) {
            $email->setStatus('error');
            $email->setError($e->getMessage());
        }

        $this->repository->save($email);
    }
}
