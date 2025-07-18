<?php

declare(strict_types=1);

namespace App\DTO;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/api/send-mail',
            controller: \App\UI\Controller\MailController::class,
            status: 200
        )
    ],
    paginationEnabled: false
)]
final class EmailInput
{
    public string $recipient;
    public string $subject;
    public string $body;
}
