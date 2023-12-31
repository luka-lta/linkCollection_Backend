<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\Link;

use LinkCollectionBackend\Exception\InvalidBodyDataException;
use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Exception\ValidationFailureException;
use LinkCollectionBackend\Repository\Link\LinkObjectRepository;
use LinkCollectionBackend\Service\AbstractActionService;
use LinkCollectionBackend\Service\ValidationService;
use LinkCollectionBackend\Value\LinkObject;

class LinkActionService extends AbstractActionService
{
    public function __construct(
        private readonly LinkObjectRepository $linkObjectRepository,
        private readonly ValidationService $validationService,
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

    public function getAllLinksFromPage(int $pageId): array
    {
        try {
            $code = 200;
            $message = $this->linkObjectRepository->getAllLinksFromPage($pageId);
        } catch (LinkCollectionException $exception) {
            $message = $exception->getMessage();
            $code = 500;
        }

        return $this->createResponseMessage($message, $code);
    }

    public function updateLink(array $payload): array
    {
        try {
            $linkObject = $this->createNewLinkObject($payload);
            $this->linkObjectRepository->updateLink($linkObject);
            $code = 201;
            $message = 'Link updated';
        } catch (LinkCollectionException $exception) {
            $message = $exception->getMessage();
            $code = 500;
        }

        return $this->createResponseMessage($message, $code);
    }

    public function deleteLink(int $linkId): array
    {
        try {
            $this->linkObjectRepository->deleteLink($linkId);
            $code = 200;
            $message = 'Link deleted';
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

        if (!isset($payload['displayName'])) {
            throw new InvalidBodyDataException('Displayname is required');
        }

        if (!$this->validationService->validateString($payload['name'])) {
            throw new InvalidBodyDataException('Name is invalid');
        }

        if (!$this->validationService->validateUrl($payload['url'])) {
            throw new InvalidBodyDataException('Url is invalid');
        }

        if (!$this->validationService->validateString($payload['displayName'])) {
            throw new InvalidBodyDataException('Displayname is invalid');
        }

        return LinkObject::fromPayload($payload);
    }
}