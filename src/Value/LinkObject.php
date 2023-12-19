<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Value;

class LinkObject
{
    private ?int $linkId;
    private string $name;
    private string $url;
    private string $displayName;

    private function __construct(?int $linkId, string $name, string $url, string $displayname)
    {
        $this->linkId = $linkId;
        $this->name = $name;
        $this->url = $url;
        $this->displayName = $displayname;
    }

    public static function from(string $name, string $url, string $displayname): self
    {
        return new self(null, $name, $url, $displayname);
    }

    public static function fromPayload(array $payload): self
    {
        return new self(
            $payload['linkId'] ?? null,
            $payload['name'],
            $payload['url'],
            $payload['displayName'],
        );
    }

    public function getLinkId(): ?int
    {
        return $this->linkId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }
}