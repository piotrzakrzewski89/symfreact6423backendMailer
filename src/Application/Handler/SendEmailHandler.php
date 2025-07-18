<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\SendEmailCommand;
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

    public function __invoke(SendEmailCommand $command): void
    {
        $email = new SendEmail();
        $email->setRecipient($command->recipient);
        $email->setSubject($command->subject);
        $email->setBody($command->body);
        $email->setSentAt(new DateTimeImmutable());

        try {
            $this->emailSender->send($command->recipient, $command->subject, $command->body);
            $email->setStatus('sent');
        } catch (\Throwable $e) {
            $email->setStatus('error');
            $email->setError($e->getMessage());
        }

        $this->repository->save($email);
    }
}
