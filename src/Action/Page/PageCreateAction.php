<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action\Page;

use LinkCollectionBackend\Action\AbstractActionHandler;
use LinkCollectionBackend\Service\Page\PageActionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PageCreateAction extends AbstractActionHandler
{
    public function __construct(
        private readonly PageActionService $pageActionService,
    )
    {
    }

    public function handlePageCreateAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $message = $this->pageActionService->createNewPage($request->getParsedBody());
        return $this->buildResponse($response, $message);
    }
}