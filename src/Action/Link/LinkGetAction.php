<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\Link;

use LinkCollectionBackend\Action\AbstractActionHandler;
use LinkCollectionBackend\Service\Link\LinkActionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LinkGetAction extends AbstractActionHandler
{
    public function __construct(
        private readonly LinkActionService $actionService
    )
    {
    }

    public function handleLinkGetAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $message = $this->actionService->getAllLinksFromPage((int)$request->getQueryParams()['pageId'] ?? 0);
        return $this->buildResponse($response, $message);
    }
}