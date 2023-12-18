<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action;

use LinkCollectionBackend\Service\LinkActionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LinkGetAction  extends AbstractActionHandler
{
    public function __construct(
        private readonly LinkActionService $actionService
    )
    {
    }

    public function handleLinkGetAction(ResponseInterface $response): ResponseInterface
    {
        $message = $this->actionService->getAllLinks();
        return $this->buildResponse($response, $message);
    }
}