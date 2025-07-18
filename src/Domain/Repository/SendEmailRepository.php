<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\SendEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class SendEmailRepository extends ServiceEntityRepository
{
    public function __construct(private EntityManagerInterface $em) {}

    public function save(SendEmail $sendEmail):void
    {
        $this->em->persist($sendEmail);
        $this->em->flush();
    }
}
