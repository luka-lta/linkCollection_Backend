<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\Page;

use LinkCollectionBackend\Action\AbstractActionHandler;
use LinkCollectionBackend\Service\Page\PageActionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PagesFromUserAction extends AbstractActionHandler
{
    public function __construct(
        private readonly PageActionService $pageActionService,
    )
    {
    }

    public function handleGetPagesFromUserAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $message = $this->pageActionService->getPagesFromUser((int)$request->getQueryParams()['ownerId']);
        return $this->buildResponse($response, $message);
    }
}