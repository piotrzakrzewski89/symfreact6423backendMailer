<?php

declare(strict_types=1);

namespace App\UI\Controller;

use App\Application\Handler\SendEmailHandler;
use App\Application\Message\SendMailMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    public function __construct(
        private SendEmailHandler $sendEmailHandler
    ) {}

    #[Route('/send-mail', name: 'send_mail', methods: ['POST'])]
    /**
     * @OA\Post(
     *     path="/send-mail",
     *     summary="Wysyła wiadomość e-mail",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="recipient", type="string", example="test@example.com"),
     *             @OA\Property(property="subject", type="string", example="Temat wiadomości"),
     *             @OA\Property(property="body", type="string", example="Treść wiadomości")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function sendMail(
        Request $request
    ): JsonResponse {

        $data = json_decode($request->getContent(), true);
        if (!isset($data['recipient'], $data['subject'], $data['body'])) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        $this->sendEmailHandler->__invoke(new SendMailMessage(
            $data['recipient'],
            $data['subject'],
            $data['body']
        ));

        return new JsonResponse(['wstatus' => 'qued'], 200);
    }
}
