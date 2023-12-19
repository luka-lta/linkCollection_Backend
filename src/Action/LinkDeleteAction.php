<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action;

use LinkCollectionBackend\Service\LinkActionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LinkDeleteAction extends AbstractActionHandler
{
    public function __construct(
        private readonly LinkActionService $actionService,
    )
    {
    }

    public function handleLinkDeleteAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $message = $this->actionService->deleteLink((int)$request->getQueryParams()['linkId']);
        return $this->buildResponse($response, $message);
    }
}