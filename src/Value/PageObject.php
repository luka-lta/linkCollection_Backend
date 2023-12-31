<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Value;

final class PageObject
{
    private ?int $pageId;
    private int $ownerId;
    private string $theme;
    private string $urlName;

    private function __construct(?int $pageId, int $ownerId, string $theme, string $urlName)
    {
        $this->pageId = $pageId;
        $this->ownerId = $ownerId;
        $this->theme = $theme;
        $this->urlName = $urlName;
    }

    public static function from(int $owner, string $theme, string $urlName): self
    {
        return new self(null, $owner, $theme, $urlName);
    }

    public static function fromPayload(array $payload): self
    {
        return new self(
            $payload['pageId'] ?? null,
            $payload['ownerId'],
            $payload['theme'],
            $payload['urlName']
        );
    }

    public function getPageId(): ?int
    {
        return $this->pageId;
    }

    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    public function getTheme(): string
    {
        return $this->theme;
    }

    public function getUrlName(): string
    {
        return $this->urlName;
    }
}