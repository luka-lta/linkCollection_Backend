<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action;

use LinkCollectionBackend\Service\LinkActionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LinkCreateAction extends AbstractActionHandler
{
    public function __construct(
        private readonly LinkActionService $actionService
    )
    {
    }

    public function handleLinkCreateAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $message = $this->actionService->createNewLink($request->getParsedBody());
        return $this->buildResponse($response, $message);
    }
}