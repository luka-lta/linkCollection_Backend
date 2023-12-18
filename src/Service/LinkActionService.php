<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service;

use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Repository\LinkObjectRepository;
use LinkCollectionBackend\Value\LinkObject;

readonly class LinkActionService
{
    public function __construct(
        private LinkObjectRepository $linkObjectRepository
    )
    {
    }

    public function createNewLink(array $payload): array
    {
        $linkObject = $this->createNewLinkObject($payload);
        $message = 'Link created';
        $code = 201;
        try {
            $this->linkObjectRepository->createNewLink($linkObject);
        } catch (LinkCollectionException $exception) {
            $message = $exception->getMessage();
            $code = 500;
        }

        return $this->createResponseMessage($message, $code);
    }

    public function getAllLinks(): array
    {
        try {
            $code = 200;
            $message = $this->linkObjectRepository->getAllLinks();
        } catch (LinkCollectionException $exception) {
            $message = $exception->getMessage();
            $code = 500;
        }

        return $this->createResponseMessage($message, $code);
    }

    public function createNewLinkObject(array $payload): LinkObject
    {
        // TODO: validate payload
        return LinkObject::fromPayload($payload);
    }

    private function createResponseMessage(string|array $message, int $code): array
    {
        return [
            'statusCode' => $code,
            'message' => $message,
        ];
    }
}