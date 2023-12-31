<?php
declare(strict_types=1);

namespace LinkCollectionBackend\Service;

abstract class AbstractActionService
{
    protected function createResponseMessage(mixed $message, int $code, array $result = null): array
    {
        if ($result !== null) {
            return [
                'message' => $message,
                'statusCode' => $code,
                'result' => $result
            ];
        }

        return [
            'message' => $message,
            'statusCode' => $code
        ];
    }
}