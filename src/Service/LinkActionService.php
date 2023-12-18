<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service;

use LinkCollectionBackend\Exception\InvalidBodyDataException;
use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Exception\ValidationFailureException;
use LinkCollectionBackend\Repository\LinkObjectRepository;
use LinkCollectionBackend\Value\LinkObject;

readonly class LinkActionService
{
    public function __construct(
        private LinkObjectRepository $linkObjectRepository,
        private ValidationService    $validationService,
    )
    {
    }

    public function createNewLink(array $payload): array
    {
        $message = 'Link created';
        $code = 201;
        try {
            $linkObject = $this->createNewLinkObject($payload);
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

    /**
     * @throws InvalidBodyDataException
     * @throws ValidationFailureException
     */
    public function createNewLinkObject(array $payload): LinkObject
    {
        if (!isset($payload['name'])) {
            throw new InvalidBodyDataException('Name is required');
        }

        if (!isset($payload['url'])) {
            throw new InvalidBodyDataException('Url is required');
        }

        if (!isset($payload['displayname'])) {
            throw new InvalidBodyDataException('Displayname is required');
        }

        if (!$this->validationService->validateString($payload['name'])) {
            throw new InvalidBodyDataException('Name is invalid');
        }

        if (!$this->validationService->validateUrl($payload['url'])) {
            throw new InvalidBodyDataException('Url is invalid');
        }

        if (!$this->validationService->validateString($payload['displayname'])) {
            throw new InvalidBodyDataException('Displayname is invalid');
        }

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