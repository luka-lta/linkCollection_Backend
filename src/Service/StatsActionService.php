<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service;

use LinkCollectionBackend\Exception\LinkCollectionException;
use LinkCollectionBackend\Repository\StatsRepository;

class StatsActionService extends AbstractActionService
{
    public function __construct(
        private readonly StatsRepository $statsRepository
    )
    {
    }

    public function getStats(): array
    {
        try {
            $code = 200;
            $message = $this->statsRepository->getStats();
        } catch (LinkCollectionException $exception) {
            $message = $exception->getMessage();
            $code = 500;
        }

        return $this->createResponseMessage($message, $code);
    }
}