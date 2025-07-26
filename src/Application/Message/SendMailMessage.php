<?php

declare(strict_types=1);

namespace App\Application\Message;

class SendMailMessage
{
    public function __construct(
        public string $recipient,
        public string $subject,
        public string $body,
    ) {}
}
