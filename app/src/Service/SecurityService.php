<?php

namespace App\Service;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class SecurityService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function registerUser(User $user): User
    {
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function createApiToken(User $user): ApiToken
    {
        $apiToken = new ApiToken($user);
        $this->em->persist($apiToken);
        $this->em->flush();
        return $apiToken;
    }
}