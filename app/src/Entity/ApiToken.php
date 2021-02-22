<?php

namespace App\Entity;

use App\Repository\ApiTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApiTokenRepository::class)
 */
class ApiToken implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $token;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $expiresAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="apiTokens")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $user;

    public function __construct(User $user)
    {
        // remove setters to make class immutable
        $this->token = bin2hex(random_bytes(20));
        $this->user = $user;
        $this->expiresAt = new \DateTime('+7 day');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getExpiresAt(): \DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function isExpired(): bool
    {
        return $this->getExpiresAt() <= new \DateTime();
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->getToken(),
            'expiresAt' => $this->getExpiresAt()->format(\DateTimeInterface::ATOM)
        ];
    }
}
