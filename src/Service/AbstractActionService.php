<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service;

abstract class AbstractActionService
{
    protected function createResponseMessage(mixed $message, int $code): array
    {
        return [
            'message' => $message,
            'statusCode' => $code
        ];
    }
}