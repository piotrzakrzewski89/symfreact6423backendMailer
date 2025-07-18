<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

interface EmailSenderInterface
{
    public function send(string $recipient, string $subject, string $body): void;
}