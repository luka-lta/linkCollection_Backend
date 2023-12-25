<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Action;

use LinkCollectionBackend\Service\StatsActionService;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class StatsAction extends AbstractActionHandler
{
    public function __construct(
        private readonly StatsActionService $actionService
    )
    {
    }

    public function handleStatsAction(Request $request, Response $response): ResponseInterface
    {
        $message = $this->actionService->getStats();
        return $this->buildResponse($response, $message);
    }
}