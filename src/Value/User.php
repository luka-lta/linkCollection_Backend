<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Value;

final class User
{
    private ?int $id;
    private string $username;
    private string $email;
    private ?string $passwordHash;

    private function __construct(?int $id, string $username, string $email, ?string $passwordHash)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public static function from(string $username, string $email): self
    {
        return new self(null, $username, $email, null);
    }

    public static function fromPayload(array $payload): self
    {
        return new self(
            $payload['id'] ?? null,
                $payload['username'],
                $payload['email'],
                $payload['password']
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(?string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }
}