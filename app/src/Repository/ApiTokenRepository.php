<?php

namespace App\Repository;

use App\Entity\ApiToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ApiTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiToken::class);
    }

    public function getExpiredTokens(): array
    {
        return $this->createQueryBuilder('api_token')
            ->where('api_token.expiresAt <= :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }

}
