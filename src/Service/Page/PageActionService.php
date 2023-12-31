<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service\Page;

use LinkCollectionBackend\Exception\InvalidBodyDataException;
use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Exception\ValidationFailureException;
use LinkCollectionBackend\Repository\Page\PageObjectRepository;
use LinkCollectionBackend\Service\AbstractActionService;
use LinkCollectionBackend\Service\ValidationService;
use LinkCollectionBackend\Value\PageObject;

class PageActionService extends AbstractActionService
{
    public function __construct(
        private readonly PageObjectRepository $pageObjectRepository,
        private readonly ValidationService    $validationService,
    )
    {
    }

    public function createNewPage(array $payload): array
    {
        $message = 'Page created';
        $code = 201;
        try {
            $pageObject = $this->createNewPageObject($payload);
            $this->pageObjectRepository->createNewPage($pageObject);
        } catch (LinkCollectionException $exception) {
            $message = $exception->getMessage();
            $code = 500;
        }

        return $this->createResponseMessage($message, $code);
    }

    public function getPagesFromUser(int $userId): array
    {
        $message = 'Pages found';
        $code = 200;
        try {
            $pages = $this->pageObjectRepository->getPagesFromUser($userId);
        } catch (LinkCollectionException $exception) {
            $message = $exception->getMessage();
            $code = 500;
        }

        return $this->createResponseMessage($message, $code, $pages ?? null);
    }

    /**
     * @throws ValidationFailureException
     * @throws InvalidBodyDataException
     */
    public function createNewPageObject(array $payload): PageObject
    {
        if (!isset($payload['ownerId'])) {
            throw new InvalidBodyDataException('OwnerID is required');
        }

        if (!isset($payload['theme'])) {
            throw new InvalidBodyDataException('Theme is required');
        }

        if (!isset($payload['urlName'])) {
            throw new InvalidBodyDataException('UrlName is required');
        }

        if (!$this->validationService->validateInt($payload['ownerId'])) {
            throw new InvalidBodyDataException('Name is invalid');
        }

        // TODO: Check if theme exists from database
        if (!$this->validationService->validateString($payload['theme'])) {
            throw new InvalidBodyDataException('Theme is invalid');
        }

        if (!$this->validationService->validateString($payload['urlName'])) {
            throw new InvalidBodyDataException('Displayname is invalid');
        }

        return PageObject::fromPayload($payload);
    }
}